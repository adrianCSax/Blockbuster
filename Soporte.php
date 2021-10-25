<?php

/*
    Crea una clase para almacenar soportes (Soporte.php). Esta clase será la clase padre de los diferentes soportes con los que trabaje nuestro videoclub (cintas de vídeo, videojuegos, etc...):
        Crea el constructor que inicialice sus propiedades. Fíjate que la clase no tiene métodos setters.
        Definir una constante IVA = 1.16
        Crear un archivo (inicio.php) para usar las clases y copia el siguiente fragmento:
*/

declare(strict_types=1);

class Soporte
{

    private static float $IVA = 1.21;

    public function __construct(
        public string $titulo,
        protected string $numero,
        private float $precio
    ){}

    public function getTitulo() : string {
        return $this->titulo;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    public function getPrecioConIva(): float {
        return $this->precio * self::$IVA;
    }

    public function mostrarResumen() : void {
        $cadena = "<br><i>" . $this->titulo ."</i><br>" . 
        $this->getPrecio() . "€ (IVA no incluido) <br>";
        echo $cadena;
    }
}
