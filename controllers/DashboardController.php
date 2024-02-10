<?php

namespace Controllers;

use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        //arrancamos sesion
        session_start();

        //proteger la url
        isAuth();

        //vistas
        $router->render('admin/dashboard/index', [
            'titulo' => 'Ver Cosultas Agendadas'
        ]);
    }
}
