<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita37f25be35653310dc816f9c9a7ac4d8
{
    public static $files = array (
        '340e41047a65cc09b33e2ef5371f13b4' => __DIR__ . '/../..' . '/backend/system/_defines.php',
        '38e19f39d4368bd47ef34588a7aaeb74' => __DIR__ . '/../..' . '/backend/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'System\\' => 7,
        ),
        'C' => 
        array (
            'Classes\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'System\\' => 
        array (
            0 => __DIR__ . '/../..' . '/backend/system',
        ),
        'Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/backend/classes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita37f25be35653310dc816f9c9a7ac4d8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita37f25be35653310dc816f9c9a7ac4d8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
