<?php


    /**
     *  Se podría usar uno o varios ficheros JSON en su lugar, pero que pereza.
     *  Además luego habría que decodificarlos.
     */

    
     /**
      * Nombre de la ruta => Método => Función a la que va a llamar en el fichero con nombre coincidente
      * Ejemeplo:     http://localhost/showroom.php/PRUEBA ->  llama a la función test() DEBE estar definida (o importada)
      * en showroom.php
      */
   define('ROUTES', [
        "generarLlamada" =>  [
            "POST" => "generarLlamada",
        ],
        "getRegistro" => [
            "POST" => "getRegistro",
        ],
        "actualizarRegistro" => [
            "POST" =>  "actualizarRegistro",
        ],
        "enviarCorreo" => [
            "POST" => "enviarCorreo",
        ],
        "crearLogs" => [
            "POST" => "crearLogs",
        ],
        "actualizarLogs" => [
            "POST" => "actualizarLogs",
        ],
        "prueba" => [
            "POST" => "pruebaPost",
            "GET" => "pruebaGet"
        ],
        "PRUEBA"=> [
            "GET" =>"test"
        ]
    ]);


    /**
     * Definimos un middleware -> función que se va a ejecutar cada vez que llamemos a un endpoint
     * en showroom.php. En este caso concreto, ejecutamos la función comprobarAuth()
     * Que verificará el usuario, blablabla, si es correcto ya ejecutamos la fn asociada al endpoint
     * 
     * POR EL MOMENTO SOLO SE PUEDE ASOCIAR 1 FUNCIÓN MIDDLEWARE A CADA FICHERO
     */
    define("MIDDLEWARE", [
        "ws_showroom.php" => "comprobarAuth",
        "showroom.php" => "comprobarAuth",
    ]);


    /**
     * Parametros que requiere el body de cada endpoint.
     * RestHelper.php se encarga de verificarlos y crear un array asociativo
     * !!Nos da igual que se envien 47 parametros, mientras contenga los X necesarios,
     * serán parseados y enviados a la función!!
     * 
     * Probablemente se añadan parámetros para poder usar filter_var definiendo tipos y longitud de los parametros
     */
    define("ROUTES_BODY", [
        "generarLlamada" => [
            "POST" => [
                "nombre",
                "apellidos",
                "telefono",
                "email",
                "showroom_origen"
            ]
        ],
        "getRegistro" => [
            "POST" => [
                "id_registro"
            ]
        ],
        "actualizarRegistro" => [
            "POST" => [
                "id",
                "call_status",
                "mail_status"
            ]
        ],
        "enviarCorreo" => [
            "POST" => [
                "id",
                "contacto",
                "correo"
            ]
        ],
        "crearLogs" => [
            "POST" => [
                "uniqueid",
                "origen",
                "nombre_ivr",
                "cliente",
                "llamante",
                "destino",
                "canal",
                "contexto",
                "fecha",
                "logs",
                "endpoint"
            ]
        ],
        "actualizarLogs" => [
            "POST" => [
                "id",
                "logs",
                "endpoint"
            ]
        ],
    ]);






?>