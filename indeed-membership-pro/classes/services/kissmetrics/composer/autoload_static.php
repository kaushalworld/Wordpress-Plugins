<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit94913b89dd4e6568ea56173fa4f13c00
{
    public static $prefixesPsr0 = array (
        'K' => 
        array (
            'KISSmetrics\\' => 
            array (
                0 => __DIR__ . '/..' . '/kissmetrics/kissmetrics-php/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit94913b89dd4e6568ea56173fa4f13c00::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
