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

/**
 * Clase que representa un VideoClub.
 * 
 * Videoclub es una clase utilizada para crear un videoclub. Guarda los Clientes y los Soportes.
 * Además, relaciona las interacciones entre estos dos generando alquileres y devoluciones.
 * 
 * @package Dwes\ProyectoVideoClub
 * @author Adrián Clement
 * @author Pedro Guilló
 * @author Damián Martín <dammardel@alu.edu.gva.es>
 */
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

        
    /**
     * __construct
     *
     * Constructor al cual se le pasa por parámetro el nombre del videoclub. 
     * Inicializa los array de socios y productos así como numuero de productos y socios. 
     * Además de el logger.
     * 
     * @param string $nombre
     * @return void
     */
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
    
    /**
     * getNumProductosAlquilados
     *
     * @return int
     */
    public function getNumProductosAlquilados(): int
    {
        return $this->numProductosAlquilado;
    }
    
    /**
     * getNumTotalAlquileres
     *
     * @return int
     */
    public function getNumTotalAlquileres(): int
    {
        return $this->numTotalAlquileres;
    }
    
    /**
     * getNumSocios
     *
     * @return int
     */
    public function getNumSocios(): int
    {
        return $this->numSocios;
    }
    
    /**
     * getSocios
     *
     * @return array
     */
    public function getSocios(): array
    {
        return $this->socios;
    }
    
    /**
     * getProductos
     *
     * @return array
     */
    public function getProductos(): array
    {
        return $this->productos;
    }
    
    /**
     * setSocios
     *
     * @param  array $socios
     * @return void
     */
    public function setSocios(array $socios)
    {
        $this->socios = $socios;
    }
    
    /**
     * incluirProducto
     * 
     * Función a la que se pasa un Soporte para que sea incluido en el 
     * array $productos.
     *
     * @param Soporte $producto
     * @return VideoClub
     */
    public function incluirProducto(Soporte $producto): VideoClub
    {
        $this->productos[$producto->getNumero()] = $producto;
        $array[] = $producto;
        $this->videoClubLogger->info("Incluído soporte " . $producto->getNumero(), $array);
        //echo "<br>Incluido soporte " . $producto->getNumero();
        return $this;
    }
    
    /**
     * incluirCintaVideo
     *
     * Función qur genera un nuevo objeto CintaVideo y lo incluye en el array de $productos de la clase VideoClub.
     * 
     * @param  string $metacritic
     * @param  string $titulo
     * @param  float $precio
     * @param  int $duracion
     * @return VideoClub
     */
    public function incluirCintaVideo(string $metacritic, string $titulo, float $precio, int $duracion): VideoClub
    {
        $video = new CintaVideo($titulo, strval($this->numProductos), $precio, $duracion);
        $video->setMetacritic($metacritic);
        $this->incluirProducto($video);
        $this->numProductos++;
        return $this;
    }

        
    /**
     * incluirDvd
     *
     * Función qur genera un nuevo objeto Dvd y lo incluye en el array de $productos de la clase VideoClub.
     * 
     * @param  string $metacritic
     * @param  string $titulo
     * @param  float $precio
     * @param  string $idiomas
     * @param  string $formatPantalla
     * @return VideoClub
     */
    public function incluirDvd(string $metacritic, string $titulo, float $precio, string $idiomas, string $formatPantalla): VideoClub
    {
        $dvd = new Dvd($titulo, strval($this->numProductos), $precio, $idiomas, $formatPantalla);
        $dvd->setMetacritic($metacritic);
        $this->incluirProducto($dvd);
        $this->numProductos++;
        return $this;
    }
    
    /**
     * incluirJuego
     *
     * Función qur genera un nuevo objeto Juego y lo incluye en el array de $productos de la clase VideoClub.
     * 
     * @param  string $metacritic
     * @param  string $titulo
     * @param  float $precio
     * @param  string $consola
     * @param  int $minJ
     * @param  int $maxJ
     * @return VideoClub
     */
    public function incluirJuego(string $metacritic, string $titulo, float $precio, string $consola, int $minJ, int $maxJ): VideoClub
    {
        $juego = new Juego($titulo, strval($this->numProductos), $precio, $consola, $minJ, $maxJ);
        $juego->setMetacritic($metacritic);
        $this->incluirProducto($juego);
        $this->numProductos++;
        return $this;
    }

        
    /**
     * incluirSocio
     *
     * Función que genera un nuevo Cliente y lo añade al array de $socios de la clase VideoClub.
     * 
     * @param  string $nombre
     * @param  string $usuario
     * @param  string $password
     * @param  int $maxAlquilerConcurrente
     * @return VideoClub
     */
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
    
    /**
     * listarProductos
     *
     * Función que lista el array $productos a través de echos.
     * 
     * @return void
     */
    public function listarProductos()
    {
        foreach ($this->productos as $producto) { 
          $producto->mostrarResumen();
            echo "<br>";
        }
    }
    
    /**
     * listarSocios
     *
     * Función que lista el array $socios a través de echos.
     * 
     * @return void
     */
    public function listarSocios()
    {
        echo "<p>Listado de " . count($this->socios) . " socios del videoclub";
        echo "<ul>";
        foreach ($this->socios as $socio) {
            echo "<li><b>Cliente </b>" . $socio->getNumero() . ": " . $socio->getNombre() . "<br>";
            echo "<b>Nombre de usuario:</b> " . $socio->getUsuario() . "<br>";
            echo "<b>Alquileres actuales: </b>" . $socio->getNumSoportesAlquilados() . "</li>";
        }
        echo "</ul>";
    }
    
    /**
     * alquilaSocioProducto
     *
     * Función que a través del $numeroCliente y $numeroSoporte establece una relación de alquiler entre ambos.
     * 
     * @param  string $numeroCliente
     * @param  string $numeroSoporte
     * 
     * @return VideoClub
     * 
     * @throws ClienteNoEncontradoException
     * @throws SoporteNoEncontradoException
     * @throws SoporteYaAlquiladoException
     */
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
    
    /**
     * alquilarSocioProductos
     *
     * Función que establece una relación entre un cliente y vaios productos. 
     * 
     * @param  string $numeroCliente
     * @param  array $productosParaAlquilar
     * @return void
     * 
     * @throws SoporteYaAlquiladoException
     */
    public function alquilarSocioProductos(string $numeroCliente, array $productosParaAlquilar)
    {
        $arrayLog = [$this->socios[$numeroCliente], $productosParaAlquilar];
        try {
            foreach ($productosParaAlquilar as $producto) {
                if (isset($this->productos[$producto])) {
                    if ($this->productos[$producto]->alquilado) {
                        $arrayLog[] = $producto;
                        // Preguntar a Aitor por esta exception
                        throw new SoporteYaAlquiladoException("El alquiler múltiple de estos productos no puede ser completado porque " . $this->productos[$producto]->getNumero() . "está alquilado");
                    }
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
    
    /**
     * devolverSocioProducto
     *
     * Función que elimina la relación de un cliente con un producto.
     * 
     * @param  string $numeroCliente
     * @param  string $numeroSoporte
     * @return void
     * 
     * @throws ClienteNoEncontradoException
     */
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
    
    /**
     * devolverSocioProductos
     *
     * Función que elimina una relación entre un cliente y vaios productos. 
     *  
     * @param  string $numeroCliente
     * @param  array $productosParaDevolver
     * @return void
     * 
     * @throws ClienteNoEncontradoException
     * @throws SoporteNoEncontradoException
     */
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
