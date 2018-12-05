<?php

namespace Rick20\PPOB\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Imuta\IBanking\IBankingManager
 */
class PPOB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ppob';
    }
}
