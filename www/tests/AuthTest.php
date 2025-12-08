<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\core\Auth;

class AuthTest extends TestCase
{
    public function test_redirect_if_not_logged_in()
    {
        $_SESSION = [];

        $this->expectException(\PHPUnit\Framework\Error\Warning::class);

        Auth::check();

        $this->assertTrue(true);
    }
}
