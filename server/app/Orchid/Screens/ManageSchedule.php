<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\RecipientsLayout;
use App\Models\Recipient;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;

class ManageSchedule extends Screen
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
        return 'ManageSchedule';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить получателя')
                ->route('platform.recipients.recipient.create')
                ->type(Color::PRIMARY),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            RecipientsLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        Recipient::findOrFail($request->get('id'))->delete();

        Toast::info(__('Address was removed'));
    }
}
