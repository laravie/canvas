<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Cache/Console/CacheTableCommand.php
 */
#[AsCommand(name: 'cache:table', description: 'Create a migration for the cache database table')]
class CacheTableCommand extends \Illuminate\Cache\Console\CacheTableCommand
{
    use MigrationGenerator;

    /**
     * Create a new session table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    #[\Override]
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files, $composer);

        $this->addGeneratorPresetOptions();
    }

    /**
     * Create a base migration file for the table.
     *
     * @param  string  $table
     * @return string
     */
    protected function createBaseMigration($table)
    {
        return $this->createBaseMigrationUsingCanvas($table);
    }

    /**
     * Determine whether a migration for the table already exists.
     *
     * @param  string  $table
     * @return bool
     */
    protected function migrationExists($table)
    {
        return $this->migrationExistsUsingCanvas($table);
    }
}
