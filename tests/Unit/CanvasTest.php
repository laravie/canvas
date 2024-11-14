<?php

namespace Orchestra\Canvas\Tests\Unit;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Canvas;
use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Presets\Package;
use PHPUnit\Framework\TestCase;

class CanvasTest extends TestCase
{
    /** @test */
    public function it_can_setup_laravel_preset()
    {
        $files = new Filesystem;
        $preset = Canvas::preset([
            'preset' => 'laravel',
            'namespace' => 'App',
            'paths' => [
                'src' => 'app',
                'resources' => 'resources',
            ],
        ], __DIR__, $files);

        $this->assertInstanceOf(Laravel::class, $preset);
        $this->assertSame([
            'namespace' => 'App',
            'paths' => [
                'src' => 'app',
                'resources' => 'resources',
            ],
        ], $preset->config());
    }

    /** @test */
    public function it_can_setup_package_preset()
    {
        $files = new Filesystem;
        $preset = Canvas::preset([
            'preset' => 'package',
            'namespace' => 'Orchestra\Foundation',
            'paths' => [
                'src' => 'src',
                'resources' => 'resources',
            ],
        ], __DIR__, $files);

        $this->assertInstanceOf(Package::class, $preset);
        $this->assertSame([
            'namespace' => 'Orchestra\Foundation',
            'paths' => [
                'src' => 'src',
                'resources' => 'resources',
            ],
        ], $preset->config());
    }
}
