<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Session/Console/SessionTableCommand.php
 */
#[AsCommand(name: 'session:table', description: 'Create a migration for the session database table')]
class SessionTableCommand extends \Illuminate\Session\Console\SessionTableCommand
{
    use MigrationGenerator;

    /**
     * Create a new session table command instance.
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
     * Create a base migration file for the session.
     *
     * @return string
     */
    #[\Override]
    protected function createBaseMigration()
    {
        return $this->createBaseMigrationUsingCanvas('sessions');
    }
}
