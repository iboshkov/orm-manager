<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ORMManager;

trait ORMManagerSupport {
    public function getRelationships() {
        return $this->relationships;
    }
}



class ORMManagerProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        require_once(app_path()."/Helpers/orm.php");

        //var_dump(config("orm.models"));
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
            'prefix' => 'orm',
        ], function ($router) {
            require base_path('routes/orm.php');
        });

        $this->app->singleton(Connection::class, function ($app) {
            return new Connection(config('name'));
        });
    }
}
