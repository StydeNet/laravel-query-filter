<?php

namespace Styde\QueryFilter\Tests\Units;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Styde\QueryFilter\Tests\TestCase;

class CommandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_filter_class()
    {
        // Destination path of the Filter class
        $path = app_path('Filters/UserFilter.php');

        // Make sure we're starting from a clean state
        if (File::exists($path)) {
            unlink($path);
        }

        $this->assertFalse(File::exists($path));

        // Run the make command
        Artisan::call('make:filter', ['name' => 'UserFilter']);

        // Assert a new file is created
        $this->assertTrue(File::exists($path));
    }

    /** @test */
    public function it_creates_a_new_query_class()
    {
        // Destination path of the Filter class
        $path = app_path('Queries/UserQuery.php');

        // Make sure we're starting from a clean state
        if (File::exists($path)) {
            unlink($path);
        }

        $this->assertFalse(File::exists($path));

        // Run the make command
        Artisan::call('make:query', ['name' => 'UserQuery']);

        // Assert a new file is created
        $this->assertTrue(File::exists($path));
    }
}
