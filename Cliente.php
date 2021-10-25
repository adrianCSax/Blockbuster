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
        if ($this->tieneAlquilado($soporte)) {
            echo "<p>El cliente ya tiene alquilado el soporte <b>" . $soporte->getTitulo() . "</b>.</p>";
            return false;
        } else if ($this->numSoprtesAlquilados == $this->maxAlquilerConcurrente) {
            echo "<p>Este cliente ya tiene " . $this->maxAlquilerConcurrente . " soportes alquilados. No puede alquilar 
            más en este videoclub hasta que no devuelva algo.</p>";
            return false;
        } else {
            array_push($this->soportesAlquilados, $soporte);
            $this->numSoprtesAlquilados++;
            echo "<br><strong>Alquilado soporte a: </strong>" . $this->nombre;
            echo "<p>" . $soporte->mostrarResumen() . "</p>";
            return true;
        }
    }

    public function devolver(int $numSoporte): bool
    {
        if ($this->numSoprtesAlquilados != 0) {
            foreach ($this->soportesAlquilados as $soporte) {
                if ($soporte->getNumero() == $numSoporte) {
                    $key = array_search($soporte, $this->soportesAlquilados);
                    unset($this->soportesAlquilados[$key]);
                    echo "<p>El soporte <b>" . $soporte->getTitulo() . "</b> ha sido devuelto.</p>";
                    return true;
                }
            }
            echo "<p>No se ha podido encontrar el soporte en los alquileres de este cliente.</p>";
            return false;
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
