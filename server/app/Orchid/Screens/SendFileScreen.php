<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\MailListLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Orchid\Support\{
    Color,
};

use App\Models\Parcel;
use App\Models\Recipient;

use Illuminate\Http\Request;

use App\Jobs\EmailSendJob;

class SendFileScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'recipients' => Recipient::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Отправить Файлы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $parcel = Parcel::with('attachment')->firstOrFail();
        $visible = count($parcel->attachment) > 0;
        return [
            MailListLayout::class,
            Layout::rows([
                Button::make('Отправить')
                ->method('submit', ['parcel' => $parcel])
                ->canSee($visible)
                ->type(Color::PRIMARY)
            ]),
        ];
    }

    public function submit(Request $request, Parcel $parcel)
    {
        /** @var Orchid\Attachment\Models\Attachment $package */
        $package = $parcel->attachment[0];

        $r = Recipient::whereIn('id', $request->address_id)->get();

        $jobs = [];

        foreach ($r as $a) {
            $jobs[] = new EmailSendJob($a, $package->physicalPath());
        }

        $batch = Bus::batch($jobs)
            ->finally(function (Batch $batch) use ($package) {
                $package->delete();
            })
            ->dispatch();
        $parcel->attachment()->sync([]);
        return redirect()->route('platform.upload');
    }
}
