<?php

class Cliente
{

    private array $soportesAlquilados;
    private int $numSoprtesAlquilados;
    private string $numero;

    public function __construct(
        public string $nombre,
        private int $maxAlquilerConcurrente = 3
    ) {
        $this->soportesAlquilados = [];
        $this->numSoprtesAlquilados = 0;
    }

    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getNumSoportesAlquilados() : int {
        return $this->numSoprtesAlquilados;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        return ($this->soportesAlquilados[$soporte->getNumero()] !== null);
    }

    public function alquilar(Soporte $soporte): bool
    {
        if ($this->tieneAlquilado($soporte)) {
            echo "<p>El cliente ya tiene alquilado el soporte <b>" . $soporte->getTitulo() . "</b>.</p>";
            return false;
        } else if ($this->numSoprtesAlquilados >= $this->maxAlquilerConcurrente) {
            echo "<p>Este cliente ya tiene " . $this->maxAlquilerConcurrente . " soportes alquilados. No puede alquilar 
            más en este videoclub hasta que no devuelva algo.</p>";
            return false;
        } else {
            $this->soportesAlquilados[$soporte->getNumero()] = $soporte;
            $this->numSoprtesAlquilados++;
            echo "<p><strong>Alquilado soporte a: </strong>" . $this->nombre;
            echo $soporte->mostrarResumen() . "</p>";
            return true;
        }
    }

    public function devolver(int $numSoporte): bool
    {
        if ($this->numSoprtesAlquilados != 0) {
            unset($this->soportesAlquilados[$numSoporte]);
            echo "<p>El soporte <b>" . $numSoporte . "</b> ha sido devuelto.</p>";
            return true;
        } else {
            echo "<p>Este cliente no tiene alquilado ningún elemento</p>";
            return false;
        }
    }

    public function listaAlquileres(): void
    {
        echo "<b>El cliente tiene " . $this->numSoprtesAlquilados . " soportes alquilados.</b><br>";
        foreach ($this->soportesAlquilados as $soporte) {
            echo $soporte->mostrarResumen();
            echo "<br>";
        }
    }
}
