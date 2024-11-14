<?php

namespace Orchestra\Canvas\Core\Tests\Unit\Presets;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Presets\Package;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    /** @test */
    public function it_has_proper_signatures()
    {
        $directory = __DIR__;
        $preset = new Package(['namespace' => 'FooBar'], $directory);

        $this->assertSame('package', $preset->name());
        $this->assertSame(['namespace' => 'FooBar'], $preset->config());
        $this->assertTrue($preset->is('package'));
        $this->assertFalse($preset->is('laravel'));

        $this->assertSame($directory, $preset->basePath());

        $this->assertSame('FooBar', $preset->rootNamespace());
        $this->assertSame('FooBar\Tests', $preset->testingNamespace());
        $this->assertSame('FooBar', $preset->modelNamespace());
        $this->assertSame('FooBar', $preset->providerNamespace());
        $this->assertSame('Database\Factories', $preset->factoryNamespace());
        $this->assertSame('Database\Seeders', $preset->seederNamespace());

        $this->assertSame("{$directory}/src", $preset->sourcePath());
        $this->assertSame("{$directory}/resources", $preset->resourcePath());
        $this->assertSame("{$directory}/database/factories", $preset->factoryPath());
        $this->assertSame("{$directory}/database/migrations", $preset->migrationPath());
        $this->assertSame("{$directory}/database/seeders", $preset->seederPath());

        $this->assertNull($preset->getCustomStubPath());
    }

    /** @test */
    public function it_can_configure_model_namespace()
    {
        $directory = __DIR__;
        $preset = new Package(['namespace' => 'FooBar', 'model' => ['namespace' => 'FooBar\Model']], $directory);

        $this->assertSame('FooBar', $preset->rootNamespace());
        $this->assertSame('FooBar\Model', $preset->modelNamespace());
        $this->assertSame('FooBar', $preset->providerNamespace());
    }

    /** @test */
    public function it_can_configure_provider_namespace()
    {
        $directory = __DIR__;
        $preset = new Package(['namespace' => 'FooBar', 'provider' => ['namespace' => 'FooBar\Providers']], $directory);

        $this->assertSame('FooBar', $preset->rootNamespace());
        $this->assertSame('FooBar', $preset->modelNamespace());
        $this->assertSame('FooBar\Providers', $preset->providerNamespace());
    }

    /** @test */
    public function it_requires_root_namespace_to_be_configured()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage("Please configure namespace configuration under 'canvas.yaml'");
        $directory = __DIR__;
        $preset = new Package([], $directory, new Filesystem);

        $preset->rootNamespace();
    }
}
