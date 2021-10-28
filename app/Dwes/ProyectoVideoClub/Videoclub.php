<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoClub;
use \Exception;

use Dwes\ProyectoVideoClub\Util\ClienteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoClub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\SoporteYaAlquiladoException;

class VideoClub
{
    private string $nombre;
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;
    private int $numProductosAlquilado;
    private int $numTotalAlquileres;

    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
    }

    public function getNumProductosAlquilados() : int {
        return $this->numProductosAlquilado;
    }

    public function getNumTotalAlquileres() : int {
        return $this->numTotalAlquileres;
    }
 
    public function getNumSocios() : int {
        return $this->numSocios;
    }

    public function incluirProducto(Soporte $producto) : VideoClub
    {
        $this->productos[$producto->getNumero()] = $producto;
        echo "<br>Incluido soporte " . $producto->getNumero();
        return $this;
    }

    public function incluirCintaVideo(string $titulo, float $precio, int $duracion) : VideoClub
    {
        $video = new CintaVideo($titulo, strval($this->numProductos),$precio, $duracion);
        $this->incluirProducto($video);
        $this->numProductos++;
        return $this;
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $formatPantalla) : VideoClub
    {
        $dvd = new Dvd($titulo, strval($this->numProductos), $precio, $idiomas, $formatPantalla);
        $this->incluirProducto($dvd);
        $this->numProductos++;
        return $this;
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ) : VideoClub
    {
        $juego = new Juego($titulo, strval($this->numProductos), $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
        $this->numProductos++;
        return $this;
    }


    public function incluirSocio(string $nombre, int $maxAlquilerConcurrente = 3) : VideoClub 
    {
        $socio = new Cliente($nombre, $maxAlquilerConcurrente);
        $socio->setNumero(strval(count(($this->socios))));
        echo "<br>Incluido Socio " . $socio->getNumero();
        $this->socios[count($this->socios)] = $socio;
        $this->numSocios++;
        return $this;
    }

    public function listarProductos()
    {
        echo "<p>";
        foreach ($this->productos as $producto) {
            $producto->mostrarResumen();
        }
        echo "</p>";
    }

    public function listarSocios()
    {
        echo "<p>Listado de " . count($this->socios) . " socios del videoclub";
        echo "<ol>";
        foreach ($this->socios as $socio) {
            echo "<li><b>-Cliente " . $socio->getNumero() . ": " . $socio->getNombre() . "<br>";
            echo "Alquileres actuales: " . $socio->getNumSoportesAlquilados();
        }
        echo "</ol>";
    }

    public function alquilaSocioProducto(string $numeroCliente, string $numeroSoporte) : VideoClub {
        
        try {
            if (!isset($this->socios[$numeroCliente])) {
                throw new ClienteNoEncontradoException("El Cliente no existe D: <br>");
            }
    
            if ($this->productos[$numeroSoporte]->alquilado) {
                throw new SoporteYaAlquiladoException("Upsi está ya cogida cari :S. No quieres alquilar Salva a Willy ;D <br>");
            }

            if (!isset($this->productos[$numeroSoporte])) {
                throw new SoporteYaAlquiladoException("Soporte no encontrado al realizar el alquiler");
            }

            $this->socios[$numeroCliente]->alquilar($this->productos[$numeroSoporte]);

        } catch (SoporteYaAlquiladoException $e) {
            echo $e->getMessage();
        }catch(CupoSuperadoException $e){
            echo $e->getMessage();
        }catch(SoporteNoEncontradoException $e){
            echo $e->getMessage();
        }
        
        return $this;
    }

    public function alquilarSocioProductos(string $numeroCliente, array $productosParaAlquilar) {
        foreach ($productosParaAlquilar as $producto) {
            if ($this->productos[$producto->getNumero()]->alquilado) {
                throw new SoporteYaAlquiladoException("Upsi esta cogida :S");
            }
            $this->alquilaSocioProducto($numeroCliente, $producto->getNumero());
        }

        return $this;
    }
}
