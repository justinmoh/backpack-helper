<?php

namespace JustinMoh\BackpackHelper\Facades\Filters;

use Illuminate\Support\Facades\Facade;

/**
 * @package JustinMoh\BackpackHelper\Facades
 *
 * @mixin \JustinMoh\BackpackHelper\CrudFilter
 */
class Select2MultipleFilter extends Facade
{

    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(self::class);

        return self::class;
    }

}