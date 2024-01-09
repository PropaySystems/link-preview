<?php
namespace Propay\LinkPreview\Integrations;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelFacade
 * @package Propay\LinkPreview\Integrations
 * @codeCoverageIgnore
 */
class LaravelFacade extends Facade
{
    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'link-preview';
    }
}
