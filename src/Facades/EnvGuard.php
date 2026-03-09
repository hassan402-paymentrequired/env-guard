<?php

namespace LaramicStudio\EnvGuard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laramic Studio\EnvGuard\EnvGuard
 */
class EnvGuard extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LaramicStudio\EnvGuard\EnvGuard::class;
    }
}
