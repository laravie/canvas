<?php

namespace Orchestra\Canvas\Tests\Feature\Presets;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Core\Presets\Package;
use Orchestra\Canvas\Presets\PackageWorkbench;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class PackageWorkbenchTest extends TestCase
{
    use WithWorkbench;

    /** @test */
    public function it_has_proper_signatures()
    {
        $directory = realpath(__DIR__.'/../../../');
        $preset = new PackageWorkbench([], $directory, $files = new Filesystem());

        $this->assertSame('workbench', $preset->name());
        $this->assertSame([], $preset->config());
        $this->assertTrue($preset->is('workbench'));
        $this->assertFalse($preset->is('package'));
        $this->assertFalse($preset->is('laravel'));

        $this->assertSame($directory, $preset->basePath());
        $this->assertSame("{$directory}/vendor/orchestra/testbench-core/laravel", $preset->laravelPath());

        $this->assertSame('Workbench\App', $preset->rootNamespace());
        $this->assertSame('Workbench\App\Models', $preset->modelNamespace());
        $this->assertSame('Workbench\App\Providers', $preset->providerNamespace());

        $this->assertSame("{$directory}/workbench/app", $preset->sourcePath());
        $this->assertSame("{$directory}/vendor", $preset->vendorPath());
        $this->assertSame("{$directory}/workbench/resources", $preset->resourcePath());
        $this->assertSame("{$directory}/workbench/database/factories", $preset->factoryPath());
        $this->assertSame("{$directory}/workbench/database/migrations", $preset->migrationPath());
        $this->assertSame("{$directory}/workbench/database/seeders", $preset->seederPath());

        $this->assertFalse($preset->hasCustomStubPath());
        $this->assertNull($preset->getCustomStubPath());

        $this->assertSame($files, $preset->filesystem());
    }
}
