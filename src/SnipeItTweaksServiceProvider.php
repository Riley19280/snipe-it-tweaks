<?php

namespace Riley19280\SnipeItTweaks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SnipeItTweaksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('snipe-it-tweaks')
            ->hasConfigFile()
            ->hasRoute('web');
    }
}
