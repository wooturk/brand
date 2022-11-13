<?php

namespace Tulparstudyo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class BrandServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Route::get('/brand', [BrandController::class, 'index']);
		Route::group(['middleware' => ['auth:sanctum']], function(){
			Route::post('/brand', [BrandController::class, 'post']);
			Route::get('/brand/{id}', [BrandController::class, 'get']);
			Route::put('/brand/{id}', [BrandController::class, 'put']);
			Route::delete('/brand/{id}', [BrandController::class, 'delete']);
		});
	}
}
