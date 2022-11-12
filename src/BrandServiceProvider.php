<?php

namespace Tulparstudyo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class PazaryerleriServiceProvider extends ServiceProvider
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
		Route::get('/pazarama', function () { return ['status'=>1]; });
	}
}
