<?php
include "vendor/autoload.php";

//si quiero usar algo fuera del namespace raiz si que tengo que hacer un use

use Dwes\ProyectoVideoClub\CintaVideo;
use Dwes\ProyectoVideoClub\Dvd;
use Dwes\ProyectoVideoClub\Juego;
use Dwes\ProyectoVideoClub\Soporte;

// 220
/* $soporte1 = new Soporte("Tenet", 22, 3); 
echo "<strong>" . $soporte1->titulo . "</strong>"; 
echo "<br>Precio: " . $soporte1->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->mostrarResumen(); */

// 221
echo "<hr>";
$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107); 
echo "<strong>" . $miCinta->titulo . "</strong>"; 
echo "<br>Precio: " . $miCinta->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
$miCinta->mostrarResumen();

// 222
echo "<hr>";
$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9"); 
echo "<strong>" . $miDvd->titulo . "</strong>"; 
echo "<br>Precio: " . $miDvd->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
$miDvd->mostrarResumen();

// 223
echo "<hr>";
$miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1); 
echo "<strong>" . $miJuego->titulo . "</strong>"; 
echo "<br>Precio: " . $miJuego->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
$miJuego->mostrarResumen();