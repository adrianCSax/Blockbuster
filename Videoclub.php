<?php

declare(strict_types=1);

class VideoClub
{

    //TODO: Probar con inicio3.php. Poner los imports correspondiente. Revisión general.

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

    public function incluirCintaVideo(string $titulo, string $numero, float $precio, int $duracion)
    {
        $video = new CintaVideo($titulo, $numero, $precio, $duracion);
        $this->incluirProducto($video);
    }

    public function incluirDvd(string $titulo, string $numero, float $precio, string $idiomas, string $formatPantalla)
    {
        $dvd = new Dvd($titulo, $numero, $precio, $idiomas, $formatPantalla);
        $this->incluirProducto($dvd);
    }

    public function incluirJuego(string $titulo, string $numero, float $precio, string $consola, int $minJ, int $maxJ)
    {
        $juego = new Juego($titulo, $numero, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
    }

    //TODO Hay que arreglarlo para que funcione sin añadir número de cliente
    public function incluirSocio(string $nombre, int $maxAlquilerConcurrente = 3)
    {
        $socio = new Cliente($nombre, $numero, $maxAlquilerConcurrente);
        $this->socios[] = $socio;
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
        echo "<ol>";
        foreach ($this->socios as $socio) {
            echo "<li><b>-Cliente " . $socio->getNumero() . ": " . $socio->getNombre() . "<br>";
            echo "Alquileres actuales: " . $socio->getNumSoportesAlquilados();
        }
        echo "</ol>";
    }

    //TODO: Encontrar el objeto en el array a partir del número de cliente. Asignar al cliente el producto
    // Del array productos a partir del número de soporte
    public function alquilarSocioProducto(string $numeroCliente, string $numeroSoporte)
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
