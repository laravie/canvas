<?php

namespace Orchestra\Canvas\Commands;

/**
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Console/ChannelMakeCommand.php
 */
class Channel extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:channel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new channel class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Channel';

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return 'channel.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Broadcasting';
    }
}
