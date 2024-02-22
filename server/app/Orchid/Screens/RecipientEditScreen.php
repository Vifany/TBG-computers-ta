<?php

namespace App\Orchid\Screens;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Recipient;
use App\Types\AddressType;
use Orchid\Screen\{
    Screen,
    Actions\Button,
    Layouts\Rows,
    Fields\Input,
    Fields\Select
    };
use Orchid\Support\{
    Color,
    Facades\Layout,
    Facades\Toast,
};

class RecipientEditScreen extends Screen
{
    public ?Recipient $recipient = null;


    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Recipient $recipient): iterable
    {
        return [
            'recipient' => $recipient,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->recipient->exists ? 'Редактировать Получателя' : 'Создать Получателя';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('save')
                ->type(Color::PRIMARY),

            Button::make('Удалить')
                ->icon('bs.trash3')
                ->method('remove')
                ->type(Color::DANGER)
                ->confirm('Удалить Получателя?')
                ->canSee($this->recipient->exists),
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
            Layout::block($this->form()),
        ];
    }

    protected function form(): Rows
    {
        return Layout::rows([
                Input::make('recipient.name')
                    ->type('text')
                    ->title('Ф.И.О.')
                    ->placeholder('Фамилия Имя Отчество'),
                Select::make('recipient.address_type')
                    ->fromEnum(AddressType::class, 'description')
                    ->title('Выберите тип адреса'),
                Input::make('recipient.address')
                    ->type('text')
                    ->title('Адрес')
                    ->placeholder('@'),
            ]);
    }

    public function save(Recipient $recipient, Request $request)
    {
        $request->validate([
            'recipient.name' => ['required', 'max:128'],
            'recipient.address' => [
                'required',
                Rule::unique(Recipient::class, 'address')->ignore($recipient),
                function ($attribute, $value, $fail) use ($request) {
                    $addressType = $request->input('recipient.address_type');
                    if ($addressType == 'tg' && !is_numeric($value)) {
                        $fail('ID Telegram может содержать только цифры и знак -');
                    }
                    if ($addressType == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('Пожалуйста, введите корректный email');
                    }
                },
            ],
        ]);
        $recipient->fill($request->collect('recipient')->toArray())
            ->save();
        Toast::info('Получатель успешно добавлен');
        return redirect()->route('platform.recipients.list');
    }

    public function remove(Recipient $recipient)
    {
        $recipient->delete();
        Toast::info('Получатель успешно удалён');
        return redirect()->route('platform.recipients.list');
    }
}
