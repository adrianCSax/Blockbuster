<?php 

namespace Dwes\ProyectoVideoClub;
require 'vendor/autoload.php';
use \Goutte\Client;

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

    public function getPuntuacion() {
        $httpClient = new Client();
        $response = $httpClient->request('GET', $this->getMetacritic());

        $response->filter('div[class="ms_wrapper"] .metascore_w')->text();
    }
}