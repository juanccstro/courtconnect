<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\models\Evento;

class EventoTest extends TestCase
{
    public function test_crear_instancia_evento()
    {
        $evento = new Evento();
        $this->assertInstanceOf(Evento::class, $evento);
    }

    public function test_obtener_por_id_devuelve_null_si_no_existe()
    {
        $evento = new Evento();
        $resultado = $evento->obtenerPorId(-999);
        $this->assertNull($resultado);
    }

    public function test_obtener_todos_devuelve_array()
    {
        $evento = new Evento();
        $lista = $evento->obtenerTodos();

        $this->assertIsArray($lista);
    }
}
