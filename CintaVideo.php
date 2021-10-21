<?php 

include_once("Soporte.php");

class CintaVideo extends Soporte {
    public function __construct(string $titulo, string $numero, float $precio, 
    private int $duracion) {
        parent::__construct($titulo, $numero, $precio);
    }

    public function mostrarResumen() : void {
        echo "<br>Película en VHS:";
        parent::mostrarResumen();
        echo "Duración: " . $this->duracion . $this->duracion < 2 ? "minuto" : "minutos";
    }
}