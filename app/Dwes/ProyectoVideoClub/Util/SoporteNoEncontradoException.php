<?php
declare(strict_types=1);

namespace Dwes\ProyectoVideoClub\Util;

class SoporteNoEncontradoException extends VideoClubException{
    public function __construct($msj, $codigo = 0, VideoClubException $previa = null) {
        // código propio
        parent::__construct($msj, $codigo, $previa);
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    public function miFuncion() {
        echo "Una función personalizada para este tipo de excepción\n";
    }
}