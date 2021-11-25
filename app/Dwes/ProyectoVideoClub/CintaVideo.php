<?php 

namespace Dwes\ProyectoVideoClub;
require 'vendor/autoload.php';
use \Goutte\Client;

/**
 * clase CintaVideo extends Soporte
 * 
 * Esta clase genera una cinta de video con las propiedades de soporte más la duración.
 * 
 * @package Dwes\ProyectoVideoClub
 * @author Adrián Clement <>
 * @author Pedro Guilló <>
 * @author Damián Martín <dammardel@alu.edu.gva.es>
 */
class CintaVideo extends Soporte {    
    /**
     * __construct
     * 
     * Constructor de la clase CintaVideo
     *
     * @param string $titulo
     * @param string $numero
     * @param float $precio
     * @param int $duracion 
     */
    public function __construct(string $titulo, string $numero, float $precio, 
    private int $duracion) {
        parent::__construct($titulo, $numero, $precio);
    }
    
    /**
     * Muestra el resumen del Juego. LLama a la misma función de Soporte para mostrar los datos generales
     * y añade información sobre la consola y el número de jugadores posible.
     *
     * @return void Muestra el resumen por pantalla
     */
    public function mostrarResumen() : void {
        $min = ($this->duracion < 2) ? "minuto" : "minutos";
        echo "<br>Película en VHS:";
        parent::mostrarResumen();
        echo "Duración: " . $this->duracion . " " . $min;
    }
    
    /**
     * Función que extrae el valor numérico de la puntuación de juego de la web Metacritic (www.metacritic.com)
     *
     * @return int Puntuación numérica obtenida en Metacritic
     */
    public function getPuntuacion() : int {
        $httpClient = new Client();
        $response = $httpClient->request('GET', $this->getMetacritic());
        return intval($response->filter('div[class="ms_wrapper"] .metascore_w')->text());
    }
}