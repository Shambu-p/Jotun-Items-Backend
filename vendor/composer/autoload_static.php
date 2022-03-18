<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitba4fedf58a82b9be4140cc0d1d9be04a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Application\\' => 12,
            'Absoft\\Line\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Application\\' => 
        array (
            0 => __DIR__ . '/../..' . '/apps',
        ),
        'Absoft\\Line\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitba4fedf58a82b9be4140cc0d1d9be04a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitba4fedf58a82b9be4140cc0d1d9be04a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitba4fedf58a82b9be4140cc0d1d9be04a::$classMap;

        }, null, ClassLoader::class);
    }
}
