<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\models\Cancha;

class CanchaTest extends TestCase
{
    public function test_modelo_cancha_existe()
    {
        $this->assertTrue(class_exists(Cancha::class));
    }

    public function test_instancia_cancha()
    {
        $cancha = new Cancha();
        $this->assertInstanceOf(Cancha::class, $cancha);
    }

    public function test_listado_canchas_es_array()
    {
        $cancha = new Cancha();
        $resultado = $cancha->getAll();

        $this->assertIsArray($resultado);
    }
}
