<?php
//https://github.com/Xeoncross/1kb-PHP-MVC-Framework/blob/master/classes/controller.php
// Controller Class
class Controller
{

    public $controller = "";
    public $action = "";
    public $roleNeedIt = "";


    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public static function LoadController($controller, $action)
    {
        $c = null;
        //if file exist?
        if (file_exists(dirname(__DIR__) . "/Controllers/" . $controller . ".php")) {
            require_once("Controllers/$controller.php");

            if (class_exists($controller)) {
                //echo "LOAD CONTROLLERR";

                $c = new $controller($controller, $action);
            } else {
                // new View("404", "Controlador no trobat")->render();
                //echo "Controlador no trobat";
            }
        } else {
            // new View("404", "Controlador no trobat")->render();
            //echo "Controlador no trobat";
        }
        return $c;
    }
    public static function isUserAnthorized($controllerObj)
    {
        $isAuth = false;
        $user_roles = self::getUserRoles();
        if (in_array($controllerObj->roleNeedIt, $user_roles)) {
            $isAuth = true;
        }
        return $isAuth;
    }
    public static function getUserRoles()
    {
        return [""]; //Agafar de sessió. 
    }
    public static function setUserRoles($user_roles)
    {
        //Posar a sessió
    }
    public function loadDb()
    {
    }
    public function doAction()
    {
    }
    public function render()
    {
        // new View("500", "Controlador incorrecte")->render();
    }
    public function fetch()
    {
        // new View("500", "Controlador incorrecte")->render();
    }
}
