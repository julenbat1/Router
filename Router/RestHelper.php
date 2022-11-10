<?php

    ## Este fichero se importa en /Helpers/Router.php
    ## Las constantes con el Body de las peticiones, sería interesante mover a otro fichero/carpeta
    ## Aparentemente funciona de manera correcta
    /**
     *  1. Verificamos que el body de la petición coincide con el enviado
     *  2. En caso afirmativo -> descodificamos el body a un array asociativo y llamamos a la fn()
     *  3. En caso negativo devolvemos  400 y exit
     */
    //Debería cambiar el nombre a StateHeaders


    enum StateHeaders: string{
        case NOT_FOUND = 'HTTP/1.1 404 Not Found';
        case OK = 'HTTP/1.1 200 OK';
        case INTERNAL_SERVER_ERROR = 'HTTP/1.1 500 Internal Server Error';
        case BAD_REQUEST = 'HTTP/1.1 400 Bad Request';
        case UNAUTHORIZED = 'HTTP/1.1 401 Unauthorized';
    }

    function getPostBody(){
        $data = file_get_contents('php://input');
        if($data === "" | !mb_detect_encoding($data, ['UTF-8'])) return;
        $body = json_decode($data, true);



        if( json_last_error() === JSON_ERROR_NONE && isValidMethodBody($body)) return constructBodyParams($body);
        else sendError(StateHeaders::BAD_REQUEST, "Data is not correct");

    }

    

    

    function isValidMethodBody(array &$body){
        $method = $_SERVER['REQUEST_METHOD'];
        $functionToCheck = getUriSplit()[2];

        $bodyStructure = ROUTES_BODY[$functionToCheck][$method];
        //Usefull if i want to define and verify variable datatypes, length, etc.
        //filter_var_array($body, [...$bodyStructure], false)
        foreach($bodyStructure as $param){
            if(!array_key_exists($param, $body)) return false;
        }
        return true;
    }


    function constructBodyParams(array &$body): array{
        //redundante
        $method = $_SERVER['REQUEST_METHOD'];
        $functionToCheck = getUriSplit()[2];
        $bodyStructure  = ROUTES_BODY[$functionToCheck][$method];

        $goodBody = [];

        foreach($bodyStructure as $key){
            $goodBody[$key] = $body[$key];
        }

        return $goodBody;
    }

    function setHeaders(array $headers): void{
        foreach($headers as $header){
            header($header);
        }
    }

    function sendData(array $data=[], array $httpHeaders=[]): never {

        setHeaders($httpHeaders);                                       
        setHeaders(["Content-Type: application/json", "Access-Control-Allow-Methods: GET, POST"]);
        $json_data = json_encode($data); // Debería ser cambiado, no tiene ningun sentido codificarlo 2 veces
        $response = ["status" => 'successfull'];

        if($json_data !== false){
            StateHeaders(StateHeaders::OK);
            $response['data'] = $data;

        } else {
            StateHeaders(StateHeaders::INTERNAL_SERVER_ERROR);
           $response["status"] = "Not sucessfull";
        }
        
        
        echo json_encode($response);
        exit(0);
    }

    function sendError(StateHeaders $headertype, $message=""): never {
        header($headertype->value);
        setHeaders(["Content-Type: application/json", "Access-Control-Allow-Methods: GET, POST"]);
        $message = json_encode(["status" => "Not successfull", "message" => $message]);
        echo $message;

        exit(0);
    }

    

    function StateHeaders(StateHeaders $headerType){
        setHeaders([$headerType->value]);
    }

    function resolve404(){
        header("HTTP/1.1 404 Not Found");
        echo "404";
        exit(0);
    }
   
?>                                                  