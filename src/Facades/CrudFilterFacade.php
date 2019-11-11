<?php

namespace JustinMoh\BackpackHelper\Facades;

use Illuminate\Support\Facades\Facade;

class CrudFilterFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(self::class);

        return self::class;
    }

}