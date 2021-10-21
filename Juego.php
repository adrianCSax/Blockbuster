<?php

include_once "Soporte.php";

class Juego extends Soporte
{

    public function __construct(
        $titulo,
        $numero,
        $precio,
        public string $consola,
        private int $minJugadores,
        private int $maxJugadores
    ) {
        parent::__construct($titulo, $numero, $precio);
    }

    public function muestraJugadoresPosibles(): string
    {
        $cadena = "";
        if ($this->minJugadores == $this->maxJugadores) {

            if ($this->minJugadores == 1) {
                $cadena .= "Para " . $this->minJugadores . " jugador";
            } else {
                $cadena .= "Para " . $this->minJugadores . " jugadores";
            }
        } else {
            $cadena .= "De " . $this->minJugadores . " a " . $this->maxJugadores . " jugadores.";
        }
        return $cadena;
    }

    public function mostrarResumen(): string
    {
        $cadena = "Juego para " . $this->consola;
        $cadena .= parent::mostrarResumen();
        $cadena .= $this->muestraJugadoresPosibles();

        return $cadena;
    }
}
