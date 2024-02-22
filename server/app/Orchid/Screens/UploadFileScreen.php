<?php

namespace App\Orchid\Screens;

use App\Models\Parcel;
use App\Models\Recipient;
use App\Orchid\CustomFields\CustomUpload;
use Orchid\Support\{
    Color,
};
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class UploadFileScreen extends Screen
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
        return 'Загрузка Файла';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Загрузить файл')
                ->method('upload')
                ->type(Color::PRIMARY)
                ->icon('bs.upload'),
            Button::make('Удалить файл')
                ->method('purge')
                ->type(Color::DANGER)
                ->icon('bs.trash'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $parcel = Parcel::with('attachment')->firstOrCreate();

        if (count($parcel->attachment) > 0) {
            /** @var Attachment $a */
            $a = $parcel->attachment[0];
            return [
                Layout::view(
                    'components.pdf',
                    [
                        'name' => $a->original_name,
                        'link' => $a->url(),
                    ]
                ),
                Layout::view('pdf-preview', ['pdfUrl' => $a->url()]),
            ];
        }
        return [
            Layout::rows([
                CustomUpload::make('uploaded_file')
                    ->acceptedFiles('application/pdf')->title('Выбрать файл')
                    ->maxFiles(1)
            ])
        ];
    }

    public function upload(Request $request)
    {
        $parcel = Parcel::firstOrCreate();

        if ($request->input('uploaded_file')) {
            $parcel->attachment()->syncWithoutDetaching($request->input('uploaded_file'));
            Alert::info('Файл успешно загружен');
        } else {
            Alert::info('Файл не выбран');
        }
    }

    public function purge(): void
    {
        $parcel = Parcel::with('attachment')->firstOrCreate();

        /**
         * @var Orchid\Attachment\Models\Attachment $a
         */
        foreach ($parcel->attachment as $a) {
            $a->delete();
        }

        Alert::info('Файл успешно удалён');
    }
}
