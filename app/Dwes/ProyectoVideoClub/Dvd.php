<?php 

namespace Dwes\ProyectoVideoClub;


class Dvd extends Soporte {

    public function __construct($titulo, $numero, $precio, public string $idiomas, private string $formatPantalla)
    {
        parent::__construct($titulo, $numero, $precio);
    }

    public function mostrarResumen() : void {
        echo "<br>Película en DVD:";
        parent::mostrarResumen();
        echo $this->idiomas . "<br>";
        echo "Formato Pantalla: " . $this->formatPantalla;
    }
}
