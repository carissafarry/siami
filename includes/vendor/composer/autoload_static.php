<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfd54a38261198a29d2c0f39ac9f023be
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
        'C' => 
        array (
            'Carissafarry\\Siami\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/..',
        ),
        'Carissafarry\\Siami\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfd54a38261198a29d2c0f39ac9f023be::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfd54a38261198a29d2c0f39ac9f023be::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfd54a38261198a29d2c0f39ac9f023be::$classMap;

        }, null, ClassLoader::class);
    }
}
