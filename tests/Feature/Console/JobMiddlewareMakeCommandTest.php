<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class JobMiddlewareMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Jobs/Middleware/Foo.php',
        'tests/Feature/Jobs/Middleware/FooTest.php',
    ];

    #[Test]
    public function it_can_generate_job_file()
    {
        $this->artisan('make:job-middleware', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs\Middleware;',
            'class Foo',
        ], 'app/Jobs/Middleware/Foo.php');

        $this->assertFilenameNotExists('tests/Feature/Jobs/Middleware/FooTest.php');
    }

    #[Test]
    public function it_can_generate_job_file_with_tests()
    {
        $this->artisan('make:job-middleware', ['name' => 'Foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFilenameExists('app/Jobs/Middleware/Foo.php');
        $this->assertFilenameExists('tests/Feature/Jobs/Middleware/FooTest.php');
    }
}
