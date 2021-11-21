<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoClub;

use \Exception;

use Dwes\ProyectoVideoClub\Util\ClienteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoClub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoClub\Util\SoporteYaAlquiladoException;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

class VideoClub
{
    private string $nombre;
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;
    private int $numProductosAlquilado;
    private int $numTotalAlquileres;
    private Logger $videoClubLogger;

    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
        $this->videoClubLogger = new Logger("VideoClubLogger-2");
        $this->videoClubLogger->pushHandler(new RotatingFileHandler("logs/videoclub.log", 0, Logger::DEBUG));
    }

    public function getNumProductosAlquilados(): int
    {
        return $this->numProductosAlquilado;
    }

    public function getNumTotalAlquileres(): int
    {
        return $this->numTotalAlquileres;
    }

    public function getNumSocios(): int
    {
        return $this->numSocios;
    }

    public function getSocios(): array
    {
        return $this->socios;
    }

    public function getProductos(): array
    {
        return $this->productos;
    }

    public function setSocios(array $socios)
    {
        $this->socios = $socios;
    }

    public function incluirProducto(Soporte $producto): VideoClub
    {
        $this->productos[$producto->getNumero()] = $producto;
        $array[] = $producto;
        $this->videoClubLogger->info("Incluído soporte " . $producto->getNumero(), $array);
        //echo "<br>Incluido soporte " . $producto->getNumero();
        return $this;
    }

    public function incluirCintaVideo(string $titulo, float $precio, int $duracion): VideoClub
    {
        $video = new CintaVideo($titulo, strval($this->numProductos), $precio, $duracion);
        $this->incluirProducto($video);
        $this->numProductos++;
        return $this;
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $formatPantalla): VideoClub
    {
        $dvd = new Dvd($titulo, strval($this->numProductos), $precio, $idiomas, $formatPantalla);
        $this->incluirProducto($dvd);
        $this->numProductos++;
        return $this;
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): VideoClub
    {
        $juego = new Juego($titulo, strval($this->numProductos), $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
        $this->numProductos++;
        return $this;
    }

    // Hacer asociativo
    public function incluirSocio(string $nombre, string $usuario, string $password, int $maxAlquilerConcurrente = 3): VideoClub
    {
        $socio = new Cliente($nombre, $usuario, $password, $maxAlquilerConcurrente);
        $socio->setNumero(strval(count(($this->socios))));
        $array[] = $socio;
        $this->videoClubLogger->info("Incluído socio " . $socio->getNumero(), $array);
        //echo "<br>Incluido Socio " . $socio->getNumero();
        $this->socios[count($this->socios)] = $socio;
        $this->numSocios++;
        return $this;
    }

    public function listarProductos()
    {
        foreach ($this->productos as $producto) { 
          $producto->mostrarResumen();
        }
    }

    public function listarSocios()
    {
        echo "<p>Listado de " . count($this->socios) . " socios del videoclub";
        echo "<ul>";
        foreach ($this->socios as $socio) {
            echo "<li><b>-Cliente " . $socio->getNumero() . ": " . $socio->getNombre() . "<br>";
            echo "<b>-Nombre de usuario: " . $socio->getUsuario() . "<br>";
            echo "Alquileres actuales: " . $socio->getNumSoportesAlquilados() . "</li>";
        }
        echo "</ul>";
    }

    public function alquilaSocioProducto(string $numeroCliente, string $numeroSoporte): VideoClub
    {

        try {
            $arrayLog = [$numeroCliente, $numeroSoporte];
            if (!isset($this->socios[$numeroCliente])) {
                throw new ClienteNoEncontradoException("El Cliente no existe D: <br>");
            }

            if (!isset($this->productos[$numeroSoporte])) {
                throw new SoporteNoEncontradoException("Soporte no encontrado al realizar el alquiler");
            } else {
                if ($this->productos[$numeroSoporte]->alquilado) {
                    throw new SoporteYaAlquiladoException("Upsi está ya cogida cari :S. No quieres alquilar Salva a Willy ;D <br>");
                }
            }

            $this->socios[$numeroCliente]->alquilar($this->productos[$numeroSoporte]);
        } catch (SoporteYaAlquiladoException $e) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        } catch (CupoSuperadoException $e) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        } catch (SoporteNoEncontradoException $e) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        }

        return $this;
    }

    public function alquilarSocioProductos(string $numeroCliente, array $productosParaAlquilar)
    {
        $arrayLog = [$this->socios[$numeroCliente], $productosParaAlquilar];
        try {
            foreach ($productosParaAlquilar as $producto) {
                if ($this->productos[$producto]->alquilado) {
                    $arrayLog[] = $producto;
                    // Preguntar a Aitor por esta exception
                    throw new SoporteYaAlquiladoException("El alquiler múltiple de estos productos no puede ser completado porque " . $this->productos[$producto]->getNumero() . "está alquilado");
                }
            }

            foreach ($productosParaAlquilar as $producto) {
                $this->alquilaSocioProducto($numeroCliente, $this->productos[$producto]->getNumero());
            }
        } catch (SoporteYaAlquiladoException $e) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        }

        return $this;
    }

    public function devolverSocioProducto(string $numeroCliente, int $numeroSoporte)
    {

        $arrayLog = [$numeroCliente, $numeroSoporte];
        try {
            if (!isset($this->socios[$numeroCliente])) {
                throw new ClienteNoEncontradoException("El Cliente no existe D: <br>");
            }

            $this->socios[$numeroCliente]->devolver($numeroSoporte);
        } catch (ClienteNoEncontradoException $e) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        }

        return $this;
    }

    public function devolverSocioProductos(string $numeroCliente, array $productosParaDevolver)
    {
        $arrayLog = [$numeroCliente, $productosParaDevolver];
        try {
            if (!isset($this->socios[$numeroCliente])) {
                throw new ClienteNoEncontradoException("No existes :$ Pero... puedes ser socio de Blockbuster ;D");
            }

            foreach ($productosParaDevolver as $producto) {
                if (!isset($this->socios[$numeroCliente]->getSoportesAlquilados()[$producto])) {
                    $arrayLog[] = $producto;
                    throw new SoporteNoEncontradoException("No tienes este soporte alquilado. No lo habrás robado ¿no? ¬_¬");
                }
            }

            foreach ($productosParaDevolver as $producto) {
                $this->devolverSocioProducto($numeroCliente, $producto);
            }
        } catch (ClienteNoEncontradoException $e) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        } catch (SoporteNoEncontradoException) {
            $this->videoClubLogger->warning($e, $arrayLog);
            echo $e->getMessage();
        }

        return $this;
    }
}
