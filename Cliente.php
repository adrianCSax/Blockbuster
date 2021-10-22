<?php

class Cliente
{

    private array $soportesAlquilados;
    private int $numSoprtesAlquilados;

    public function __construct(
        public string $nombre,
        private string $numero,
        private int $maxAlquilerConcurrente = 3
    ) {
        $this->soportesAlquilados = [];
    }

    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function tieneAlquilado(Soporte $soporte): bool
    {
        return in_array($soporte, $this->soportesAlquilados);
    }

    public function alquilar(Soporte $soporte): bool
    {
        if (!$this->tieneAlquilado($soporte) && ($this->numSoprtesAlquilados < $this->maxAlquilerConcurrente)) {
            array_push($this->soportesAlquilados, $soporte);
            $this->numSoprtesAlquilados++;
            echo "<strong>Alquilado soporte a </strong>" . $this->nombre;
            $soporte->mostrarResumen();

            return true;
        }
        echo "<strong>No se ha podido alquilar</strong>" . $this->nombre;
        return false;
    }

    public function devolver(int $numSoporte): bool
    {
        foreach ($this->soportesAlquilados as $soporte) {
            if ($soporte->getNumero() == $numSoporte) {
                $key = array_search($soporte, $this->soportesAlquilados);
                unset($this->soportesAlquilados[$key]);
                return true;
            }
        }
        return false;
    }
}
