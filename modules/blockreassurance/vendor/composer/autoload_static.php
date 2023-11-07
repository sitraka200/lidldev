<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit96848b1e2ca2fea37ba4f4889e2c3a0b
{
    public static $files = array (
        'ad155f8f1cf0d418fe49e248db8c661b' => __DIR__ . '/..' . '/react/promise/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\CssSelector\\' => 30,
        ),
        'R' => 
        array (
            'React\\Promise\\' => 14,
        ),
        'P' => 
        array (
            'PrestaShop\\Module\\BlockReassurance\\' => 35,
            'PrestaShop\\CircuitBreaker\\' => 26,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Subscriber\\Cache\\' => 28,
            'GuzzleHttp\\Stream\\' => 18,
            'GuzzleHttp\\Ring\\' => 16,
            'GuzzleHttp\\' => 11,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Cache\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\CssSelector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/css-selector',
        ),
        'React\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/promise/src',
        ),
        'PrestaShop\\Module\\BlockReassurance\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'PrestaShop\\CircuitBreaker\\' => 
        array (
            0 => __DIR__ . '/..' . '/prestashop/circuit-breaker/src',
        ),
        'GuzzleHttp\\Subscriber\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/cache-subscriber/src',
        ),
        'GuzzleHttp\\Stream\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/streams/src',
        ),
        'GuzzleHttp\\Ring\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/ringphp/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Doctrine\\Common\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/cache/lib/Doctrine/Common/Cache',
        ),
    );

    public static $classMap = array (
        'ReassuranceActivity' => __DIR__ . '/../..' . '/classes/ReassuranceActivity.php',
        'blockreassurance' => __DIR__ . '/../..' . '/blockreassurance.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit96848b1e2ca2fea37ba4f4889e2c3a0b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit96848b1e2ca2fea37ba4f4889e2c3a0b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit96848b1e2ca2fea37ba4f4889e2c3a0b::$classMap;

        }, null, ClassLoader::class);
    }
}
