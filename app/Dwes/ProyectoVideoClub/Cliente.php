<?php

declare(strict_types=1);

//solo indicamos namespace
//No hacemos los use de Soporte porque están en el mismo namespace
namespace Dwes\ProyectoVideoClub;

use Dwes\ProyectoVideoClub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoClub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\SoporteYaAlquiladoException;
use \Exception;

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

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getNumSoportesAlquilados(): int
    {
        return $this->numSoprtesAlquilados;
    }

    public function setNumero(string $numero): Cliente
    {
        $this->numero = $numero;
        return $this;
    }

    public function tieneAlquilado(Soporte $soporte): bool
    {
        return (isset($this->soportesAlquilados[$soporte->getNumero()]));
    }

    public function alquilar(Soporte $soporte): Cliente
    {
        try {
            if ($this->tieneAlquilado($soporte)) {
                throw new SoporteYaAlquiladoException("Error al alquilar el soporte " . $soporte->getTitulo());
            }
            if ($this->numSoprtesAlquilados >= $this->maxAlquilerConcurrente) {
                throw new CupoSuperadoException("Error has superado el máximo cupo de Soportes alquilados ");
            }
        } catch (SoporteYaAlquiladoException $e) {
            echo $e->getMessage();
        } catch (CupoSuperadoException $e) {
            echo $e->getMessage();
        }


        $soporte->alquilado = true;
        $this->soportesAlquilados[$soporte->getNumero()] = $soporte;
        $this->numSoprtesAlquilados++;
        echo "<p><strong>Alquilado soporte a: </strong>" . $this->nombre;
        echo $soporte->mostrarResumen() . "</p>";

        return $this;
    }

    public function devolver(int $numSoporte): Cliente
    {
        try {
            if (!isset($this->soportesAlquilados[$numSoporte])) {
                throw new SoporteNoEncontradoException("No tienes alquilada esta peli cari ;D");
            }
            if ($this->numSoprtesAlquilados >= $this->maxAlquilerConcurrente) {
                throw new CupoSuperadoException("No puedes alquilar más cari devulve algo ;3");
            }
        } catch (SoporteNoEncontradoException $e) {
            echo $e->getMessage();
        } catch (CupoSuperadoException $e) {
            echo $e->getMessage();
        }
        //FIXME: Error en inicio2.php "Attempt to assign property "alquilado" on null"
        $this->soportesAlquilados[$numSoporte]->alquilado = false;
        unset($this->soportesAlquilados[$numSoporte]);
        echo "<p>El soporte <b>" . $numSoporte . "</b> ha sido devuelto.</p>";

        return $this;
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
