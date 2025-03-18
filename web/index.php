<?php
require_once("includes.php");

$action = "";

if (isset($_GET["controller"])) {
    $controller = $_GET["controller"] . "Controller";
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    }
} else {
    $controller = "indexController";
    // new View("404", "Controlador no trobat")->render();
    //echo "No autoritzat!";
}

$controllerObj = Controller::LoadController($controller, $action);
if ($controllerObj) {
    $isAuth = Controller::isUserAnthorized($controllerObj);
    if ($isAuth) {
        $controllerObj->loadDB();
        $controllerObj->doAction();
        if(str_contains($action, "fetch")){
            $controllerObj->fetch();
        }else{
            $controllerObj->render();
        }
    } else {
        // new View("403", "No autoritzat")->render();
        echo "no autoritzat";
    }
} else {
    View::render("404", ["msg" => "No trobat, controllerObj no definit"]);
    //echo "no trobat";
}
