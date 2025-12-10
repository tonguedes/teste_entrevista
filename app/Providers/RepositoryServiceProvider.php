<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Produto\ProdutoRepositoryInterface;
use App\Repositories\Produto\EloquentProdutoRepository;
use App\Services\ProdutoService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProdutoRepositoryInterface::class, EloquentProdutoRepository::class);

        // opcional: singleton para o service
        $this->app->singleton(ProdutoService::class, function ($app) {
            return new ProdutoService($app->make(ProdutoRepositoryInterface::class));
        });
    }

    public function boot()
    {
        //
    }
}
