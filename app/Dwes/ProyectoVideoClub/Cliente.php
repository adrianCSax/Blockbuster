<?php
declare (strict_types = 1);

//solo indicamos namespace
//No hacemos los use de Soporte porque están en el mismo namespace
namespace Dwes\ProyectoVideoClub;
use Dwes\ProyectoVideoClub\Util;
use Dwes\ProyectoVideoClub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoClub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\SoporteYaAlquiladoException;

class Cliente extends VideoClub
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
        $this->numero = "0";
    }

    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function getNombre() : string {
        return $this->nombre;
    }

    public function getNumSoportesAlquilados() : int {
        return $this->numSoprtesAlquilados;
    }

    public function setNumero(string $numero): Cliente
    {
        $this->numero = $numero;
        return $this;
    }

    public function tieneAlquilado(Soporte $soporte): bool {
        return (isset($this->soportesAlquilados[$soporte->getNumero()]));
    }

    public function alquilar(Soporte $soporte) : Cliente
    {
        if ($this->tieneAlquilado($soporte)) {
            throw new SoporteYaAlquiladoException("Error al alquilar el soporte ". $soporte->getTitulo());
        }if ($this->numSoprtesAlquilados >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("Error has superado el máximo cupo de Soportes alquilados ");
        } else {
            $this->soportesAlquilados[$soporte->getNumero()] = $soporte;
            if (isset($this->soportesAlquilados[$soporte->getNumero()])) {
                throw new SoporteNoEncontradoException("Error no se ha encontrado el soporte ");
                
            }
            $this->numSoprtesAlquilados++;
            echo "<p><strong>Alquilado soporte a: </strong>" . $this->nombre;
            echo $soporte->mostrarResumen() . "</p>";
            return $this;
        }
    }

    public function devolver(int $numSoporte): Cliente
    {
        if ($this->numSoprtesAlquilados != 0) {
            unset($this->soportesAlquilados[$numSoporte]);
            echo "<p>El soporte <b>" . $numSoporte . "</b> ha sido devuelto.</p>";
            return $this;
        } else {
            echo "<p>Este cliente no tiene alquilado ningún elemento</p>";
            return $this;
        }
    }

    public function listaAlquileres() : void
    {
        echo "<b>El cliente tiene " . $this->numSoprtesAlquilados . " soportes alquilados.</b><br>";
        foreach ($this->soportesAlquilados as $soporte) {
            echo $soporte->mostrarResumen();
            echo "<br>";
        }
    }
}
