<?php

declare(strict_types=1);
include_once "Juego.php";
include_once "Dvd.php";
include_once "CintaVideo.php";
include_once "Cliente.php";

class VideoClub
{
    private string $nombre;
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;

    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
    }

    public function incluirProducto(Soporte $producto)
    {
        $this->productos[] = $producto;
    }

    public function incluirCintaVideo(string $titulo, float $precio, int $duracion)
    {

        $video = new CintaVideo($titulo, strval($this->numProductos),$precio, $duracion);
        $this->incluirProducto($video);
        echo "<br>Incluido soporte " . $video->getNumero();
        $this->numProductos++;
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $formatPantalla)
    {
        $dvd = new Dvd($titulo, strval($this->numProductos), $precio, $idiomas, $formatPantalla);
        $this->incluirProducto($dvd);
        echo "<br>Incluido soporte " . $dvd->getNumero();
        $this->numProductos++;
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ)
    {
        $juego = new Juego($titulo, strval($this->numProductos), $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
        echo "<br>Incluido soporte " . $juego->getNumero();
        $this->numProductos++;
    }


    public function incluirSocio(string $nombre, int $maxAlquilerConcurrente = 3)
    {
        $socio = new Cliente($nombre, $maxAlquilerConcurrente);
        $socio->setNumero(count($this->socios));
        echo "<br>Incluido Socio " . $socio->getNumero();
        $this->socios[] = $socio;
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
            echo "<li><b>-Cliente " . $socio->getNumero() . ": " . $socio->nombre . "<br>";
            echo "Alquileres actuales: " . $socio->getNumSoportesAlquilados();
        }
        echo "</ol>";
    }

    public function alquilaSocioProducto(string $numeroCliente, string $numeroSoporte)
    {
        foreach ($this->socios as $socio) {
            if ($socio->getNumero() == $numeroCliente) {
                foreach ($this->productos as $producto) {
                    if ($producto->getNumero() == $numeroSoporte) {
                        $socio->alquilar($producto);
                    }
                }
            }
        }
    }
}
