<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Overwrite any vendor / package configuration.
     *
     * This service provider is intended to provide a convenient location for you
     * to overwrite any "vendor" or package configuration that you may want to
     * modify before the application handles the incoming request / command.
     *
     * @return void
     */
    public function register()
    {
        # Adding Hipchat handler to Monolog logger for non-production environments.
        if (!\App::environment('production')) {
            $hipchatConfig = \Config::get('services.hipchat');
            $hipchatHandler = new \Monolog\Handler\HipChatHandler(
                $hipchatConfig['token'],
                $hipchatConfig['room'],
                $hipchatConfig['name'],
                false,
                $hipchatConfig['level']
            );

            \Log::getMonolog()->pushHandler($hipchatHandler);
        }

        config([
            //
        ]);
    }
}
