<?php

namespace Dwes\ProyectoVideoClub;


class Juego extends Soporte {

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

    public function muestraJugadoresPosibles(): string {
        if ($this->minJugadores == $this->maxJugadores) {
            $jugadoresString = ($this->minJugadores === 1) ? " jugador" : " jugadores";
            return "Para " . $this->minJugadores . $jugadoresString;
        } else {
            return "De " . $this->minJugadores . " a " . $this->maxJugadores . " jugadores.";
        }
    }

    public function mostrarResumen(): void {
        echo "<br>Juego para " . $this->consola;
        parent::mostrarResumen();
        echo $this->muestraJugadoresPosibles();
    }
}
