<?php 

include_once "Soporte.php";

class Dvd extends Soporte {

    public function __construct($titulo, $numero, $precio, public string $idiomas, private string $formatPantalla)
    {
        parent::__construct($titulo, $numero, $precio);
    }

    public function mostrarResumen() : string {
        $cadena = "Película en DVD <br>";
        $cadena .= parent::mostrarResumen();
        $cadena .= $this->idiomas . "<br>" . 
        "Formato Pantalla: " . $this->formatPantalla;
        return $cadena;
    }
}
