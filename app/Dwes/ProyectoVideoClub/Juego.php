<?php

namespace Dwes\ProyectoVideoClub;

use \Goutte\Client;

/**
 * La clase juego hereda de Soporte añadiendo los datos de consola, mínimo de jugadores y máximo de jugadores
 * 
 * @package Dwes\ProyectoVideoClub
 * @author Adrián Clement <>
 * @author Pedro Guilló <>
 * @author Damián Martín <dammardel@alu.edu.gva.es>
 */
class Juego extends Soporte
{

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

    /**
     * Muestra como cadena de texto el número de jugadores posibles. Si el mínimo y el máximo son iguales mostrará
     * Para x jugadores (para 1 jugador), en otro caso devolverá (De x a x jugadores)
     *
     * @return string Cadena que indica el rango de jugadores del Juego
     */
    public function muestraJugadoresPosibles(): string
    {
        if ($this->minJugadores == $this->maxJugadores) {
            $jugadoresString = ($this->minJugadores === 1) ? " jugador" : " jugadores";
            return "Para " . $this->minJugadores . $jugadoresString;
        } else {
            return "De " . $this->minJugadores . " a " . $this->maxJugadores . " jugadores.";
        }
    }

    /**
     * Muestra el resumen del Juego. LLama a la misma función de Soporte para mostrar los datos generales
     * y añade información sobre la consola y el número de jugadores posible.
     *
     * @return void Muestra el resumen por pantalla
     */
    public function mostrarResumen(): void
    {
        echo "<br>Juego para " . $this->consola;
        parent::mostrarResumen();
        echo $this->muestraJugadoresPosibles();
    }

    /**
     * Función que extrae el valor numérico de la puntuación de juego de la web Metacritic (www.metacritic.com)
     *
     * @return integer Puntuación numérica obtenida en Metacritic
     */
    public function getPuntuacion(): int {
        $httpClient = new Client();
        $response = $httpClient->request('GET', $this->getMetacritic());
        return intval($response->filter('span[itemprop="ratingValue"]')->text());       
    }
}
