<?php

namespace Vendor\MyPackage;

use Illuminate\Support\ServiceProvider;

class MyPackageServiceProvider extends ServiceProvider
{
    /**
     * Регистрация любых служб приложения.
     *
     * @return void
     */
    public function register()
    {
        // Регистрация зависимостей пакета
    }

    /**
     * Выполнение любых начальных действий после загрузки всех служб.
     *
     * @return void
     */
    public function boot()
    {
        // Публикация конфигурационных файлов, маршрутов, миграций и т.д.
    }
}

