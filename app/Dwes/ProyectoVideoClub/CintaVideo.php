<?php 

namespace app\Dwes\ProyectoVideoClub;

include_once "autoload.php";

class CintaVideo extends Soporte {
    public function __construct(string $titulo, string $numero, float $precio, 
    private int $duracion) {
        parent::__construct($titulo, $numero, $precio);
    }

    public function mostrarResumen() : void {
        $min = ($this->duracion < 2) ? "minuto" : "minutos";
        echo "<br>Película en VHS:";
        parent::mostrarResumen();
        echo "Duración: " . $this->duracion . " " . $min;
    }
}