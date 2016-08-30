<?php
$config = Symfony\CS\Config::create()
    ->fixers(
        [
            'single_blank_line_before_namespace',
            'concat_with_spaces',
        ]
    )
    ->finder(
        Symfony\CS\Finder::create()
            ->exclude('vendor')
            ->exclude('var')
            ->exclude('app')
            ->exclude('public')
            ->exclude('node_modules')
            ->exclude('docker')
            ->exclude('bin')
            ->name('*.php')
            ->in(__DIR__)
    )
;

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;
$config
    ->setUsingCache(true)
    ->setDir($cacheDir);

return $config;
