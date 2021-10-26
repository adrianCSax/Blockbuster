<?php

declare(strict_types=1);

/*
    Crea una clase para almacenar soportes (Soporte.php). Esta clase será la clase padre de los diferentes soportes con los que trabaje nuestro videoclub (cintas de vídeo, videojuegos, etc...):
        Crea el constructor que inicialice sus propiedades. Fíjate que la clase no tiene métodos setters.
        Definir una constante IVA = 1.16
        Crear un archivo (inicio.php) para usar las clases y copia el siguiente fragmento:
*/

namespace Dwes\ProyectoVideoClub;

include_once "Resumible.php";

/*328 Que consigues al hacerla abstracta? Básicamente se abstraen implementaciones del padre para darsela a lo hijos
 obligando a las clases hijas a heredar los metodos marcados como abstractos. Con esto conseguimos una clase padre más simplificada
 haciendo uso del polimorfismo. Por ejemplo: En esta clase que debería ser marcado como asbtracto es "mostrarResumen()", ya que
 sus hijos CintaVideo, Dvd y Juego tienen diferentes implementaciones. Sin embargo no lo hemos hecho porque cada uno de los hijos,
 llamamos a la clase padre para reducir la complejidad del código.
 YA no se puede instaciar al hacerla abstracta.
*/

abstract class Soporte implements Resumible {

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
