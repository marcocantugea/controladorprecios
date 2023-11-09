<?php

namespace App\Providers;

use App\Repositories\OrganizacionRepository;
use App\Services\OrganizacionService;
use Illuminate\Support\ServiceProvider;
use App\Mappers\OrganizacionMapper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->scoped(OrganizacionMapper::class,function($app){
            return new OrganizacionMapper();
        });

        $this->app->scoped(OrganizacionRepository::class,function($app){
            return new OrganizacionRepository();
        });

        $this->app->scoped(OrganizacionService::class,function($app){
            return new OrganizacionService($app[OrganizacionRepository::class],$app[OrganizacionMapper::class]);
        });
    }
}
