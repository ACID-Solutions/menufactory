<?php namespace AcidSolutions\MenuFactory;

use Illuminate\Support\ServiceProvider;

class MenuFactoryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['menufactory'] = $this->app->share(function($app)
	    {
	        return new MenuFactory;
	    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('menufactory');
	}

}