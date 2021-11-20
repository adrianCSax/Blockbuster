<?php

declare(strict_types=1);

//solo indicamos namespace
//No hacemos los use de Soporte porque están en el mismo namespace
namespace Dwes\ProyectoVideoClub;

use Dwes\ProyectoVideoClub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoClub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\SoporteYaAlquiladoException;
use Monolog\Logger;
use \Exception;
use Monolog\Handler\RotatingFileHandler;

class Cliente extends VideoClub

{

    private array $soportesAlquilados;
    private int $numSoprtesAlquilados;
    private string $numero;
    private Logger $videoLogger;


    public function __construct(
        public string $nombre,
        private string $usuario,
        private string $password,
        private int $maxAlquilerConcurrente = 3,
    ) {
        $this->soportesAlquilados = [];
        $this->numSoprtesAlquilados = 0;
        $this->numero = "0";
        $this->videoLogger = new Logger ("VideoclubLogger");
        $this->videoLogger->pushHandler(new RotatingFileHandler("logs/videoclub.log",0,Logger::DEBUG));

    }

    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getNumSoportesAlquilados(): int
    {
        return $this->numSoprtesAlquilados;
    }

    public function getAlquileres() : array {
        return $this->soportesAlquilados;
    }

    public function setPassword(string $password) : Cliente {
        $this->password = $password;
        return $this;
    }

    public function setNombre(string $nombre) : Cliente {
        $this->nombre = $nombre;
        return $this;
    }
    
    public function setUsuario(string $usuario) : Cliente {
        $this->usuario = $usuario;
        return $this;
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
                //$this->videoLogger->warning("Error al alquilar el soporte " . $soporte->getTitulo());
                throw new SoporteYaAlquiladoException("Error al alquilar el soporte " . $soporte->getTitulo());
            }
            if ($this->numSoprtesAlquilados >= $this->maxAlquilerConcurrente) {
                //$this->videoLogger->warning("Error has superado el máximo cupo de Soportes alquilados");
                throw new CupoSuperadoException("Error has superado el máximo cupo de Soportes alquilados ");
            }

            $soporte->alquilado = true;
            $this->soportesAlquilados[$soporte->getNumero()] = $soporte;
            $this->numSoprtesAlquilados++;

            $this->videoLogger->info("Alquilado soporte " . $soporte->getTitulo() . " a: " . $this->nombre);

           // echo "<p><strong>Alquilado soporte a: </strong>" . $this->nombre;
            //echo $soporte->mostrarResumen() . "</p>";

        } catch (SoporteYaAlquiladoException $e) {
            $this->videoLogger->warning($e);
            echo $e->getMessage();
        } catch (CupoSuperadoException $e) {
            $this->videoLogger->warning($e);
            echo $e->getMessage();
        }

        return $this;
    }

    public function devolver(int $numSoporte): Cliente
    {
        try {
            if (!isset($this->soportesAlquilados[$numSoporte])) {
                throw new SoporteNoEncontradoException("No tienes alquilada esta peli cari ;D");
            }

            $this->soportesAlquilados[$numSoporte]->alquilado = false;
            unset($this->soportesAlquilados[$numSoporte]);
            $this->numSoprtesAlquilados--;
            $this->videoLogger->info("El soporte " . $numSoporte . " ha sido devuelto");

            //echo "<p>El soporte <b>" . $numSoporte . "</b> ha sido devuelto.</p>";

        } catch (SoporteNoEncontradoException $e) {
            $this->videoLogger->warning($e); //Puesto aquí para ver lo que muestra.
            echo $e->getMessage();
        }
    
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
