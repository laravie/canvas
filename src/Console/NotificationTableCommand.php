<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Notifications/Console/NotificationTableCommand.php
 */
#[AsCommand(name: 'notifications:table', description: 'Create a migration for the notifications table')]
class NotificationTableCommand extends \Illuminate\Notifications\Console\NotificationTableCommand
{
    use MigrationGenerator;

    /**
     * Create a new notifications table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files, $composer);

        $this->addGeneratorPresetOptions();
    }

    /**
     * Create a base migration file for the notifications.
     *
     * @return string
     */
    #[\Override]
    protected function createBaseMigration()
    {
        return $this->createBaseMigrationUsingCanvas('notifications');
    }
}
