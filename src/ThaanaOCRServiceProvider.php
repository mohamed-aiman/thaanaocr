<?php

namespace Aimme\ThaanaOCR;

use Aimme\ThaanaOCR\Vision\API as VisionAPI;
use Aimme\ThaanaOCR\ThaanaOCR;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ThaanaOCRServiceProvider extends ServiceProvider
{

    public function register()
    {
        $configPath = __DIR__ . '/../config/thaanaocr.php';
        $this->mergeConfigFrom($configPath, 'thaana-ocr');

        $this->app->bind(ClientInterface::class, Client::class);

        $this->app->singleton(VisionAPI::class, function () {
                $client = $this->app->make(ClientInterface::class);
                $api = new VisionAPI($client);
                return $api;
            }
        );

        $this->app->singleton(ThaanaOCR::class, function () {
                $api = $this->app->make(VisionAPI::class);
                $ocrHandler = new ThaanaOCR($api);
                return $ocrHandler;
            }
        );
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__.'/resources/views/', 'thaana-ocr');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::namespace('Aimme\ThaanaOCR\Http\Controllers')
            ->middleware(['web'])
            ->as('thaana-ocr.')
            ->prefix('thaanaocr')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
            });
    }
}
