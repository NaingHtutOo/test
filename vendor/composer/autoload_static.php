<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited551b735461c913c6b87587cafd842a
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Libs\\' => 5,
        ),
        'H' => 
        array (
            'Helpers\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Libs\\' => 
        array (
            0 => __DIR__ . '/../..' . '/_classes/Libs',
        ),
        'Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/_classes/Helpers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited551b735461c913c6b87587cafd842a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited551b735461c913c6b87587cafd842a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInited551b735461c913c6b87587cafd842a::$classMap;

        }, null, ClassLoader::class);
    }
}
