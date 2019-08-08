<?php

//Imprime los resultados en pantalla
//echo file_get_contents('https://xkcd.com/info.0.json').PHP_EOL;

$json = file_get_contents('https://xkcd.com/info.0.json').PHP_EOL;

$data = json_decode( $json, true );

//Solo muestra la información de la imagen
echo $data['img'].PHP_EOL;