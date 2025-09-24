<?php

namespace Fatrex\FilamentQueueTracker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentQueueTrackerServiceProvider extends PackageServiceProvider
{
    // Controls view/translation/config namespace (e.g. 'filament-queue-tracker::')
    public static string $name = 'filament-queue-tracker';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            // Keep the config file name explicit during the rename; please rename the
            // config file to config/filament-queue-tracker.php in your repo.
            ->hasConfigFile('filament-queue-tracker')
            ->hasTranslations()
            ->hasMigration('create_filament-queue-tracker_table');
    }
}
