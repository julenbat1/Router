<?php

    /**
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     *  DESPUES DE HACER LAS QUERY
     *   TAREA PENDIENTE:
     *      DEFINIR TODAS LAS CONSTANTES EN OTRO FICHERO
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */

    // require_once './Router/Confiles/showroom.php';
    require_once './Router/RestHelper.php';

    (function(){
        if(checkRoute()){
            $route = getUriSplit()[1];
            require_once "./Router/Confiles/${route}";
        } else resolve404();
    })();

    
    function redirect(){
        if(checkRoute()){
            $endpoint = getUriSplit()[2];
            $isvalid = validateRouteAndMethod($endpoint);
            if($isvalid) {
                execAdditionalCheck();
                callEndpoint($endpoint);
            }
            resolve404();
        }
    } 
    function execAdditionalCheck(){
        $file = getUriSplit()[1];
        if(array_key_exists($file, MIDDLEWARE)){
            $checkResult = call_user_func(MIDDLEWARE[$file]);
        if(!$checkResult){
            sendError(StateHeaders::UNAUTHORIZED, "Wrong Credentials");
            // var_dump($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        }
        }
    }
    
    function checkRoute(){
        if(count(getUriSplit()) >= 3) return true;
        else return false;
    }
    
    
    function callEndpoint($endpoint){
        $fname = ROUTES[$endpoint][$_SERVER["REQUEST_METHOD"]]; // si cambiamos esto, podría ser reutilizable
        if($_SERVER["REQUEST_METHOD"] === 'GET') call_user_func($fname);
        call_user_func($fname, ...getPostBody());
        
    }
    
    // function getPostData(){
        //     $data = file_get_contents("php://input");
        //     $_data = json_decode($data, true);
        
        //     return $_data;
        // }
        
        //Esto también debería cambiarse
    function validateRouteAndMethod(string $routeName): bool{
        $methodKey = $_SERVER['REQUEST_METHOD'];
        if(isset(ROUTES[$routeName])  && array_key_exists($methodKey, ROUTES[$routeName])){
            return true;
        } else {
            return false;
        }
    }
        
        
        
    function getUriSplit(){
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
            
        return $uri;
    }
        
?>