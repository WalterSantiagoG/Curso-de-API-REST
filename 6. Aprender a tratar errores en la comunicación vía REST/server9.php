<?php

//Definimos los recursos disponibles
$allowedResourceTypes = [
    'books',
    'authors',
    'generes',
];

//Validamos que el recurso este disponible
$resourceType = $_GET['resource_type'];

if ( !in_array($resourceType, $allowedResourceTypes) ) {
    http_response_code(400);
    die;
}

//Defino los recursos
$books = [
    1 => [
        'titulo' => 'Lo que el viento se llevo',
        'id_autor' => 2,
        'id_genero' => 2,
    ],
    2 => [
        '
        titulo' => 'La Iliada',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
    3 => [
        'titulo' => 'La Odisea',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
];

header('Content-Type: application/json');

//Levantamos el id del recurso buscado
$resourceId = array_key_exists('resource_id',$_GET) ? $_GET['resource_id'] : '';

//Generamos la respuesta asumiendo que el pedido es correcto
switch ( strtoupper($_SERVER['REQUEST_METHOD']) ) {
    case 'GET':
        if ( empty( $resourceId ) ) {
            echo json_encode($books);
        } else {
            if ( array_key_exists($resourceId, $books)) {
                echo json_encode($books[ $resourceId ]);
            }else{
                http_response_code(404);
            }
        }
        
        break;
    case 'POST':
        $json = file_get_contents('php://input');

        //Transformamos el json recibido a un nuevo elemento del array
        $books[] = json_decode($json, true);

        //echo array_keys($books)[ count($books) - 1 ];
        echo json_encode($books);
        break;
    case 'PUT':
        if ( !empty( $resourceId ) && array_key_exists($resourceId, $books) ) {
            //Tomamos la entrada cruda
            $json = file_get_contents('php://input');

            //Transformamos el json recibido para modificar un elemento del array
            $books[ $resourceId ] = json_decode($json, true);
            
            //Retornamos la coleccion modificada al formato json
            echo json_encode($books);
        }
        break;
    case 'DELETE':
        //Validamos que el recurso exista
        if ( !empty( $resourceId ) && array_key_exists($resourceId, $books) ) {
            //Eliminamos el recurso
            unset($books[$resourceId]);
            
            echo json_encode($books);
        }
        break;
}

?>