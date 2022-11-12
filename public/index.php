<?php

require __DIR__ . '/../vendor/autoload.php';


require __DIR__ . '/../app/Controllers/MainController.php';
require __DIR__ . '/../app/Controllers/CatalogController.php';


$router = new AltoRouter();

//dump($_SERVER);



$router->setBasePath($_SERVER['BASE_URI']);


$router->map(

    'GET', //method http autorisé pour cette route
    '/', //la partie url aprés la racine
    [
        'controller' => 'MainController',
        'method' => 'homeAction',
    ],
    'main-home', //identifiant unique pour cette route
);

$router->map(

    'GET', //method http autorisé pour cette route
    '/catalogue/categorie/[i:id]', //la partie url aprés la racine
    [
        'controller' => 'CatalogController',
        'method' => 'categoryAction',
    ],
    'categorie', //identifiant unique pour cette route
);


//on check s'il une route correspondante existe à la route demandé
$match = $router->match();


//dump($match);


if ($match !== false) {



    //on récupère dans $routeInfos toutes les infos  associé à notre route
    $routeInfos = $match['target'];
    //dump($routeInfos);

    //on récupère le nom du controller
    $controllerToUse = $routeInfos['controller'];


    //on récupère le nom de la méthod
    $methodToCall = $routeInfos['method'];

    //infos dynamique de l'url
    $urlParams = $match['params'];

    //var_dump($controllerToUse);
    //var_dump($methodToCall);

    //on instancie le bon controller
    $controller = new $controllerToUse();

    //on appel la méthod du bon controller
    $controller->$methodToCall($urlParams);

    
} else {
    //page 404 si la ressource n'est pas trouvée
    $controller = new MainController();
    $controller->pageNotFound();
}
