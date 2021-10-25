<?php 
declare (strict_types=1);

class VideoClub {

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

    public function incluirProducto (Soporte $producto) {
        $this->productos[] = $producto;
    }

    public function incluirCintaVideo (string $titulo, string $numero, float $precio, int $duracion) {
        $video = new CintaVideo($titulo, $numero, $precio, $duracion);
        $this->productos[] = $video;
    }

    public function incluirDvd (string $titulo, string $numero, float $precio, string $idiomas, string $formatPantalla) {
        $dvd = new Dvd($titulo, $numero, $precio, $idiomas, $formatPantalla);
        $this->productos[] = $dvd;
    }

    public function incluirJuego (string $titulo, string $numero, float $precio, string $consola, int $minJ, int $maxJ) {
        $juego = new Juego($titulo, $numero, $precio, $consola, $minJ, $maxJ);
        $this->productos[] = $juego;
    }





}