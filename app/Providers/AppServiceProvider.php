<?php

namespace App\Providers;

use Barryvdh\Debugbar\DataCollector\QueryCollector;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\Services\DataTable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()?->boolean('custom_parsing', false)) {
            QueryCollector::addCustomFrameParser(DataTable::class, function (object $frame, array $trace) {
                // Remove the 'App\' prefix from the namespace
                $relativeNamespace = str_replace('App\\', '', $trace['object']::class);

                // Convert namespace to a directory path
                $directoryPath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeNamespace);
                $filePath = app_path($directoryPath) . '.php';

                // Get the file path inside the project from the class object
                $frame->file = $filePath;

                return $frame;
            });
        }
    }
}
