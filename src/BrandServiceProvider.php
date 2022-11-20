<?php

namespace Wooturk;

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
		Route::get('/brand', [BrandController::class, 'index'])->name('brand-index');
		Route::get('/brands', [BrandController::class, 'list'])->name('brand-list');
		// Models
		Route::get('/brand/{id}', [BrandController::class, 'get'])->name('brand-get');
		Route::get('/brand/{id}/models', [BrandController::class, 'models'])->name('brand-models');

		Route::group(['middleware' => ['auth:sanctum','wooturk.gateway']], function(){
			Route::post('/brand', [BrandController::class, 'post'])->name('brand-create');
			Route::put('/brand/{id}', [BrandController::class, 'put'])->name('brand-update');
			Route::delete('/brand/{id}', [BrandController::class, 'delete'])->name('brand-delete');
			// Models
			Route::post('/model', [BrandController::class, 'model_post'])->name('models-create');
			Route::put('/model/{id}', [BrandController::class, 'model_put'])->name('models-update');
			Route::delete('/model/{id}', [BrandController::class, 'model_delete'])->name('models-delete');
		});
	}
}
