<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Инструкция')
                ->icon('bs.list')
                ->route('platform.main'),
            Menu::make('Загрузить Файл')
                ->icon('bs.card-list')
                ->title('Рассылка файла')
                ->route('platform.upload'),

            Menu::make('Редактирование Получателей')
                ->icon('bs.book')
                ->route('platform.recipients.list'),

            Menu::make('Отправить Файл')
                ->icon('bs.collection')
                ->route('platform.send'),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
