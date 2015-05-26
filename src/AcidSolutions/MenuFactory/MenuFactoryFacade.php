<?php namespace AcidSolutions\MenuFactory;

use Illuminate\Support\Facades\Facade;
 
class MenuFactoryFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'menufactory'; }
 
}