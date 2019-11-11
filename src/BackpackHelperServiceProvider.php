<?php

namespace JustinMoh\BackpackHelper;

use JustinMoh\BackpackHelper\Facades\Columns\BooleanColumn;
use JustinMoh\BackpackHelper\Facades\Columns\ClosureColumn;
use JustinMoh\BackpackHelper\Facades\Columns\DateColumn;
use JustinMoh\BackpackHelper\Facades\Columns\DatetimeColumn;
use JustinMoh\BackpackHelper\Facades\Columns\NumberColumn;
use JustinMoh\BackpackHelper\Facades\Columns\SelectColumn;
use JustinMoh\BackpackHelper\Facades\Columns\SelectMultipleColumn;
use JustinMoh\BackpackHelper\Facades\Columns\TextareaColumn;
use JustinMoh\BackpackHelper\Facades\Columns\TextColumn;
use JustinMoh\BackpackHelper\Facades\CrudColumnFacade;
use JustinMoh\BackpackHelper\Facades\CrudFieldFacade;
use JustinMoh\BackpackHelper\Facades\CrudFilterFacade;
use JustinMoh\BackpackHelper\Facades\Fields\DatePickerField;
use JustinMoh\BackpackHelper\Facades\Fields\DatetimePickerField;
use JustinMoh\BackpackHelper\Facades\Fields\HiddenField;
use JustinMoh\BackpackHelper\Facades\Fields\NumberField;
use JustinMoh\BackpackHelper\Facades\Fields\RadioField;
use JustinMoh\BackpackHelper\Facades\Fields\Select2Field;
use JustinMoh\BackpackHelper\Facades\Fields\Select2FromArrayField;
use JustinMoh\BackpackHelper\Facades\Fields\Select2MultipleField;
use JustinMoh\BackpackHelper\Facades\Fields\SelectField;
use JustinMoh\BackpackHelper\Facades\Fields\SelectFromArrayField;
use JustinMoh\BackpackHelper\Facades\Fields\TextareaField;
use JustinMoh\BackpackHelper\Facades\Fields\TextField;
use JustinMoh\BackpackHelper\Facades\Fields\UploadMultipleField;
use JustinMoh\BackpackHelper\Facades\Filters\DateRangeFilter;
use JustinMoh\BackpackHelper\Facades\Filters\Select2MultipleFilter;
use JustinMoh\BackpackHelper\Facades\Filters\SimpleFilter;
use Illuminate\Support\ServiceProvider;

class BackpackHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/backpack-helper.php',
            'backpack-helper'
        );

        $this->registerFieldFacades();
        $this->registerColumnFacades();
        $this->registerFilterFacades();
    }


    protected function registerFilterFacades()
    {
        $this->app->bind(
            CrudFilterFacade::class,
            function () {
                return new CrudFilter();
            }
        );


        $this->app->bind(
            DateRangeFilter::class,
            function () {
                return new CrudFilter('date_range');
            }
        );
        $this->app->bind(
            Select2MultipleFilter::class,
            function () {
                return new CrudFilter('select2_multiple');
            }
        );
        $this->app->bind(
            SimpleFilter::class,
            function () {
                return new CrudFilter('simple');
            }
        );
    }


    protected function registerColumnFacades()
    {
        $this->app->bind(
            CrudColumnFacade::class,
            function () {
                return new CrudColumn();
            }
        );


        $this->app->bind(
            BooleanColumn::class,
            function () {
                return new CrudColumn('boolean');
            }
        );
        $this->app->bind(
            ClosureColumn::class,
            function () {
                return new CrudColumn('closure');
            }
        );
        $this->app->bind(
            DateColumn::class,
            function () {
                return new CrudColumn('date');
            }
        );
        $this->app->bind(
            DatetimeColumn::class,
            function () {
                return new CrudColumn('datetime');
            }
        );
        $this->app->bind(
            NumberColumn::class,
            function () {
                return new CrudColumn('number');
            }
        );
        $this->app->bind(
            SelectColumn::class,
            function () {
                return new CrudColumn('select');
            }
        );
        $this->app->bind(
            SelectMultipleColumn::class,
            function () {
                return new CrudColumn('select_multiple');
            }
        );
        $this->app->bind(
            TextColumn::class,
            function () {
                return new CrudColumn('text');
            }
        );
        $this->app->bind(
            TextareaColumn::class,
            function () {
                return new CrudColumn('textarea');
            }
        );
    }


    protected function registerFieldFacades()
    {
        $this->app->bind(
            CrudFieldFacade::class,
            function () {
                return new CrudField();
            }
        );

        $this->app->bind(
            DatePickerField::class,
            function () {
                return new CrudField('date_picker');
            }
        );
        $this->app->bind(
            DatetimePickerField::class,
            function () {
                return new CrudField('datetime_picker');
            }
        );
        $this->app->bind(
            HiddenField::class,
            function () {
                return new CrudField('hidden');
            }
        );
        $this->app->bind(
            NumberField::class,
            function () {
                return new CrudField('number');
            }
        );
        $this->app->bind(
            RadioField::class,
            function () {
                return new CrudField('radio');
            }
        );
        $this->app->bind(
            SelectField::class,
            function () {
                return new CrudField('select');
            }
        );
        $this->app->bind(
            Select2Field::class,
            function () {
                return new CrudField('select2');
            }
        );
        $this->app->bind(
            Select2MultipleField::class,
            function () {
                return new CrudField('select2_multiple');
            }
        );
        $this->app->bind(
            Select2FromArrayField::class,
            function () {
                return new CrudField('select2_from_array');
            }
        );
        $this->app->bind(
            SelectFromArrayField::class,
            function () {
                return new CrudField('select_from_array');
            }
        );
        $this->app->bind(
            TextareaField::class,
            function () {
                return new CrudField('textarea');
            }
        );
        $this->app->bind(
            TextField::class,
            function () {
                return new CrudField('text');
            }
        );
        $this->app->bind(
            UploadMultipleField::class,
            function () {
                return new CrudField('upload_multiple');
            }
        );
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'justinmoh');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'justinmoh');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }


//    /**
//     * Get the services provided by the provider.
//     *
//     * @return array
//     */
//    public function provides()
//    {
//        return ['backpack-helper'];
//    }


    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes(
            [
                __DIR__.'/../config/backpack-helper.php'
                => config_path('backpack-helper.php'),
            ],
            'backpack-helper.config'
        );

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/justinmoh'),
        ], 'backpack-helper.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/justinmoh'),
        ], 'backpack-helper.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/justinmoh'),
        ], 'backpack-helper.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
