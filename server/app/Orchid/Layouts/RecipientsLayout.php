<?php

namespace App\Orchid\Layouts;

use App\Models\Recipient;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RecipientsLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'recipients';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'ФИО'),
            TD::make('address', 'Адрес'),
            TD::make('address_type', 'Тип адреса')
                ->render(
                    fn(Recipient $recipient) => $recipient->address_type->description()
                ),
            TD::make('actions', '')
                ->render(fn (Recipient $recipient) =>Group::make([

                    Link::make('Править')
                        ->route('platform.recipients.recipient.edit', $recipient->id)
                        ->icon('bs.pencil'),

                    Button::make('Удалить')
                        ->method('remove', ['id' => $recipient->id])
                        ->icon('bs.trash')
                        ->confirm('Удалить получателя?'),


                ])->autoWidth()),
        ];
    }
}
