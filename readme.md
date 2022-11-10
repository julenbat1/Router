## Example of usage

Create a file   testfile.php
### Inside testfile.php
  include_once './Router/Router.php';
  after all fundamental imports, call redirect() method.
  
  declare all functions your endpoints will be calling.
  
### Go Router/confiles
Crate a new file with the same name as the one before (testfile)

Declare 3 constants  ROUTES, MIDDLEWARE, ROUTES_BODY

ROUTES -> you will declare the endpoit name => method => function name that will be call (declared in testfile.php)

example ROUTES => ["testEndpoint" => ["POST" => "testFn"]]   on localhost/testfile.php/testEndpoint will be executed testFn declared inside 

MIDDLEWARE -> you will define ["testfile.php" => "middlewareFnToBeCalled"] this function name has also to be declared on the file testfile.php
It will be called everytime you call any endpoint inside /testfile.php/*
For now it only supports single file execution.

ROUTES_BODY you will declare all parameters requires for each endpoint, in the future, supposed to also support declaring each parameter type so it can be all checked with
filter_var()

