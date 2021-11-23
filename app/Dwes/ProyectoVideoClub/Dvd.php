<?php 

namespace Dwes\ProyectoVideoClub;
require 'vendor/autoload.php';
use \Goutte\Client;

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

    public function getPuntuacion() {
        $httpClient = new Client();
        $response = $httpClient->request('GET', $this->getMetacritic());

        $response->filter('div[class="ms_wrapper"] .metascore_w')->text();
    }
}
