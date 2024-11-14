<?php

namespace Orchestra\Canvas\Console;

use Orchestra\Canvas\Core\Commands\GeneratorCommand;
use Orchestra\Canvas\Core\Concerns\ResolvesPresetStubs;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:user-model', description: 'Create the User model class')]
class UserModelMakeCommand extends GeneratorCommand
{
    use ResolvesPresetStubs;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    #[\Override]
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/user-model.stub');
    }

    /**
     * Resolve the default fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveDefaultStubPath($stub)
    {
        return __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     */
    #[\Override]
    public function getDefaultNamespace($rootNamespace)
    {
        return rtrim($this->generatorPreset()->modelNamespace(), '\\');
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    #[\Override]
    protected function getNameInput()
    {
        return 'User';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    #[\Override]
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    #[\Override]
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the generator already exists'],
        ];
    }
}
