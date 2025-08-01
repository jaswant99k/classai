<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3b2767e5f6d7f23e0867d0a9cd139123
{
    public static $prefixLengthsPsr4 = array (
        'R' =>
        array (
            'Razorpay\\Tests\\' => 15,
            'Razorpay\\Api\\' => 13,
        ),
        'M' =>
        array (
            'Modules\\RazorPay\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Razorpay\\Tests\\' =>
        array (
            0 => __DIR__ . '/..',
        ),
        'Razorpay\\Api\\' =>
        array (
            0 => __DIR__ . '/..',
        ),
        'Modules\\RazorPay\\' =>
        array (
            0 => __DIR__ . '/../..',
        ),
    );

    public static $prefixesPsr0 = array (
        'R' =>
        array (
            'Requests' =>
            array (
                0 => __DIR__ . '/..',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3b2767e5f6d7f23e0867d0a9cd139123::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3b2767e5f6d7f23e0867d0a9cd139123::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit3b2767e5f6d7f23e0867d0a9cd139123::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
