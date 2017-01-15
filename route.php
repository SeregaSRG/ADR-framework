<?php
class Route {
    static function start() {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if($routes[1] == 'api') {
            $action = $routes[2];
        } else {
            Route::ErrorPage404();
        }

        // добавляем префиксы
        $domains_name = 'Domain_'.$action;
        $action_name = 'Action_'.$action;

        // подцепляем файлы
        if( file_exists('application/actions/'.$action_name.'.php') ) {
            require_once 'application/actions/'.$action_name.'.php';
        } else {
            Route::ErrorPage404();
        }

        if( file_exists('application/domains/'.$domains_name.'.php') ) {
            require_once 'application/domains/'.$domains_name.'.php';
        } else {
            Route::ErrorPage404();
        }

        $action = new $action_name;
    }

    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}