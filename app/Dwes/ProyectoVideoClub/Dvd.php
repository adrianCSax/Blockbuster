<?php

namespace Dwes\ProyectoVideoClub;

use \Goutte\Client;

/**
 * La clase juego hereda de Soporte añadiendo los datos idiomas y formato de pantalla.
 * 
 * @package Dwes\ProyectoVideoClub
 * @author Adrián Clement <>
 * @author Pedro Guilló <>
 * @author Damián Martín <dammardel@alu.edu.gva.es>
 */
class Dvd extends Soporte {

    public function __construct($titulo, $numero, $precio, public string $idiomas, private string $formatPantalla) {
        parent::__construct($titulo, $numero, $precio);
    }

    /**
     * Muestra el resumen del DVD. LLama a la misma función de Soporte para mostrar los datos generales
     * y añade información sobre los idiomas y el formato de pantalla.
     *
     * @return void Muestra el resumen por pantalla
     */
    public function mostrarResumen(): void {
        echo "<br>Película en DVD:";
        parent::mostrarResumen();
        echo $this->idiomas . "<br>";
        echo "Formato Pantalla: " . $this->formatPantalla;
    }

    /**
     * Función que extrae el valor numérico de la puntuación de juego de la web Metacritic (www.metacritic.com)
     *
     * @return integer Puntuación numérica obtenida en Metacritic
     */
    public function getPuntuacion(): int {
        $httpClient = new Client();
        $response = $httpClient->request('GET', $this->getMetacritic());

        return intval($response->filter('div[class="ms_wrapper"] .metascore_w')->text());
    }
}
