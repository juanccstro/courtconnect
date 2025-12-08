<?php

use PHPUnit\Framework\TestCase;
use App\models\Evento;

class EventoTest extends TestCase
{
    public function test_crear_evento_instancia_modelo()
    {
        $evento = new Evento();
        $this->assertInstanceOf(Evento::class, $evento);
    }
}
