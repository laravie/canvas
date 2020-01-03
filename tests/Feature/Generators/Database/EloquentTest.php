<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Carbon\Carbon;
use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class EloquentTest extends TestCase
{
    protected $files = [
        'app/Foo.php',
        'app/Foo/Bar.php',
        'app/Http/Controllers/FooController.php',
        'app/Http/Controllers/BarController.php',
        'database/factories/FooFactory.php',
        'database/seeds/FooSeeder.php',
    ];

    /** @test */
    public function it_can_generate_eloquent_file()
    {
        $this->artisan('make:model', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Foo.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_pivot_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--pivot' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'use Illuminate\Database\Eloquent\Relations\Pivot;',
            'class Foo extends Pivot',
        ], 'app/Foo.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--controller' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Foo.php');


        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeds/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_factory_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--factory' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Foo.php');

        $this->assertFilenameNotExists('app/Htt/Controllers/FooController.php');
        $this->assertFilenameExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeds/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_seeder_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--seed' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Foo.php');

        $this->assertFilenameNotExists('app/Htt/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameExists('database/seeds/FooSeeder.php');
    }


    /** @test */
    public function it_can_generate_nested_eloquent_with_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo/Bar', '--controller' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Foo;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Bar extends Model',
        ], 'app/Foo/Bar.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class BarController extends Controller',
        ], 'app/Http/Controllers/BarController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeds/FooSeeder.php');
    }
}
