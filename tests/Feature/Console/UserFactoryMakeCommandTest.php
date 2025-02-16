<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserFactoryMakeCommandTest extends TestCase
{
    protected $files = [
        'database/factories/UserFactory.php',
    ];

    #[Test]
    public function it_can_generate_broadcasting_channel_file()
    {
        $this->artisan('make:user-factory', ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Database\Factories;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'use App\Models\User;',
            '* @template TModel of \App\Models\User',
            '* @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>',
            'class UserFactory extends Factory',
            'protected $model = User::class;',
        ], 'database/factories/UserFactory.php');
    }
}
