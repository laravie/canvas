<?php

namespace Orchestra\Canvas\Console;

use Laravel\Dusk\Console\MakeCommand;
use Orchestra\Canvas\Core\Concerns\CodeGenerator;
use Orchestra\Canvas\Core\Concerns\UsesGeneratorOverrides;
use Orchestra\Canvas\GeneratorPreset;

/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Routing/Console/ControllerMakeCommand.php
 */
#[AsCommand(name: 'make:dusk', description: 'Create a new Dusk test class')]
class DuskMakeCommand extends MakeCommand
{
    use CodeGenerator;
    use UsesGeneratorOverrides;

    /**
     * Configures the current command.
     *
     * @return void
     */
    #[\Override]
    protected function configure()
    {
        parent::configure();

        $this->addGeneratorPresetOptions();
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    #[\Override]
    public function handle()
    {
        /** @phpstan-ignore return.type */
        return $this->generateCode() ? self::SUCCESS : self::FAILURE;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function generatingCode($stub, $name)
    {
        $preset = $this->generatorPreset();

        if (! $preset instanceof GeneratorPreset) {
            return $stub;
        }

        $testCase = $preset->canvas()->config(
            'testing.extends.browser',
            $preset->canvas()->is('laravel') ? 'Tests\DuskTestCase' : 'Orchestra\Testbench\Dusk\TestCase'
        );

        return $this->replaceTestCase($stub, $testCase);
    }

    /**
     * Replace the model for the given stub.
     */
    protected function replaceTestCase(string $stub, string $testCase): string
    {
        $namespaceTestCase = $testCase = str_replace('/', '\\', $testCase);

        if (str_starts_with($testCase, '\\')) {
            $stub = str_replace('DummyNamespace', trim($testCase, '\\'), $stub);
        } else {
            $stub = str_replace('DummyNamespace', $namespaceTestCase, $stub);
        }

        $stub = str_replace(
            "use {$namespaceTestCase};\nuse {$namespaceTestCase};", "use {$namespaceTestCase};", $stub
        );

        $testCase = class_basename(trim($testCase, '\\'));

        return str_replace('DummyClass', $testCase, $stub);
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        $preset = $this->generatorPreset();

        if (! $preset instanceof GeneratorPreset) {
            return parent::resolveStubPath($stub);
        }

        return $preset->hasCustomStubPath() && file_exists($customPath = join_paths($preset->basePath(), $stub))
            ? $customPath
            : $this->resolveDefaultStubPath($stub);
    }

    /**
     * Resolve the default fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveDefaultStubPath($stub)
    {
        return join_paths(__DIR__, $stub);
    }

    /**
     * Get the generator preset source path.
     */
    protected function getGeneratorSourcePath(): string
    {
        return $this->generatorPreset()->testingPath();
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->getPathUsingCanvas($name);
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->generatorPreset()->testingNamespace().'Browser\\';
    }
}
