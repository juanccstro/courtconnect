<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\models\Cancha;

class CanchaTest extends TestCase
{
    public function test_model_exists()
    {
        $this->assertTrue(class_exists(Cancha::class));
    }
}
