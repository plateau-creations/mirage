<?php
namespace Plateau\Mirage;
use Illuminate\Support\Facades\Facade;


class MirageFacade extends Facade {
	
	 /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'mirage'; }

}