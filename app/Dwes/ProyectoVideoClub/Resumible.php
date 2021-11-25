<?php

namespace Dwes\ProyectoVideoClub;

/**
 * Interfaz Resumible
 * 
 * Interfaz que se aplica si se quiere implementar el método mostrarResumen
 * 
 * @package Dwes\ProyectoVideoClub
 * @author Adrián Clement
 * @author Pedro Guilló
 * @author Damián Martín <dammardel@alu.edu.gva.es>
 */

interface Resumible {    
    
    /**
     * mostrarResumen
     *
     * @return void
     */
    public function mostrarResumen() : void;
}