<?php

class Cliente {

    private array $soportesAlquilados;
    private int $numSoprtesAlquilados;

    public function __construct(
        public string $nombre,
        private string $numero,
        private int $maxAlquilerConcurrente = 3
    ){
        $this->soportesAlquilados = [];
    }

    public function getSoportesAlquilados() : array {
        return $this->soportesAlquilados;
    }

    public function getNumero() : int {
        return $this->numero;
    }
    public function setNumero(int $numero) : void {
        $this->numero = $numero;
    }

    public function tieneAlquilado(Soporte $soporte) : bool {
        return in_array($soporte, $this->soportesAlquilados);
    }

    public function alquilar(Soporte $soporte) : bool {
        if (!$this->tieneAlquilado($soporte) && ($this->numSoprtesAlquilados < $this->maxAlquilerConcurrente)) {
            array_push($this->soportesAlquilados, $soporte);
            $this->numSoprtesAlquilados++;
            echo "<strong>Alquilado soporte a </strong>" . $this->nombre; 
            return true;
        } 
        echo "<strong>No se ha podido alquilar</strong>" . $this->nombre; 
        return false;
    }
}