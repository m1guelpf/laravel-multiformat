<?php

namespace M1guelpf\Multiformat;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;

class MultiformatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Route::macro('multiformat', function () {
            return $this->setUri($this->uri().'{_format?}');
        });

        Request::macro('match', function ($responses, $defaultFormat = 'html') {
            if ($this->route('_format') === null) {
                return value(Arr::get($responses, $this->format($defaultFormat)));
            }

            return value(array_get($responses, str_after($this->route('_format'), '.'), function () {
                abort(404);
            }));
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
