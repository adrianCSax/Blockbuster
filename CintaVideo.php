<?php 

include_once("Soporte.php");

class CintaVideo extends Soporte {
    public function __construct(string $titulo, string $numero, float $precio, 
    private int $duracion)
    {
        parent::__construct($titulo, $numero, $precio);
    }

    public function mostrarResumen() : string {
        $cadena = "Película en VHS <br>";
        $cadena .= parent::mostrarResumen();
        $cadena .= "Duración: " . $this->duracion;

        return $cadena;
    }
}