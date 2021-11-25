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

/**
 * Clase que representa un Cliente.
 * 
 * Esta clase contiene un cliente de VideoClub el cual tiene un array de alquileres.
 * 
 * @package Dwes\ProyectoVideoClub
 * @author Adrián Clement
 * @author Pedro Guilló
 * @author Damián Martín <dammardel@alu.edu.gva.es>
 */
class Cliente extends VideoClub {

    private array $soportesAlquilados;
    private int $numSoprtesAlquilados;
    private string $numero;
    private Logger $videoLogger;

    
    /**
     * __construct
     *
     * Constuctor que inicializa el array de soportesAlquilados, el numSoportesAlquilados
     * y el Logger. Así como el cliente.
     * 
     * @param string $nombre
     * @param string $usuario
     * @param string $password
     * @param int $maxAlquilerConcurrente (default = 3)
     * 
     * @return void
     */
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
    
    /**
     * getSoportesAlquilados
     *
     * @return array
     */
    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }
    
    /**
     * getUsuario
     *
     * @return string
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }
    
    /**
     * getNombre
     *
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }
    
    /**
     * getPassword
     *
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }
    
    /**
     * getNumSoportesAlquilados
     *
     * @return int
     */
    public function getNumSoportesAlquilados(): int
    {
        return $this->numSoprtesAlquilados;
    }
    
    /**
     * getAlquileres
     *
     * @return array
     */
    public function getAlquileres() : array {
        return $this->soportesAlquilados;
    }
    
    /**
     * setPassword
     *
     * @param  string $password
     * @return Cliente
     */
    public function setPassword(string $password) : Cliente {
        $this->password = $password;
        return $this;
    }
    
    /**
     * setNombre
     *
     * @param  string $nombre
     * @return Cliente
     */
    public function setNombre(string $nombre) : Cliente {
        $this->nombre = $nombre;
        return $this;
    }
        
    /**
     * setUsuario
     *
     * @param  string $usuario
     * @return Cliente
     */
    public function setUsuario(string $usuario) : Cliente {
        $this->usuario = $usuario;
        return $this;
    }
    
    /**
     * setNumero
     *
     * @param  string $numero
     * @return Cliente
     */
    public function setNumero(string $numero): Cliente
    {
        $this->numero = $numero;
        return $this;
    }
    
    /**
     * tieneAlquilado
     *
     * Función que comprueba que un soporte no está alquilado por el cliente.
     * 
     * @param  Soporte $soporte
     * @return bool
     */
    public function tieneAlquilado(Soporte $soporte): bool
    {
        return (isset($this->soportesAlquilados[$soporte->getNumero()]));
    }
    
    /**
     * alquilar
     *
     * Función que añade un Soporte al array de $soportesAlquilados.
     * 
     * @param  Soporte $soporte
     * @return Cliente
     * 
     * @throws SoporteYaAlquiladoException
     * @throws CupoSuperadoException
     */
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
    
    /**
     * devolver
     *
     * Función que elimina un Soporte del array de soportesAlquilados. Eliminando un alquiler.
     * 
     * @param  int $numSoporte
     * @return Cliente
     * 
     * @throws SoporteNoEncontradoException
     */
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
    
    /**
     * listaAlquileres
     *
     * Función que hace un echo de todos los alquileres(soportesAlquilados) del cliente.
     * 
     * @return void
     */
    public function listaAlquileres(): void
    {
        echo "<b>El cliente tiene " . $this->numSoprtesAlquilados . " soportes alquilados.</b><br>";
        foreach ($this->soportesAlquilados as $soporte) {
            echo $soporte->mostrarResumen();
            echo "<br>";
        }
    }
}
