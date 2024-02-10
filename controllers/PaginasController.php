<?php

namespace Controllers;

use MVC\Router;

class PaginasController
{
    public static function index(Router $router)
    {


        //Vistas
        $router->render('paginas/index', [
            'titulo' => 'Inicio'
        ]);
    }

    public static function nosotros(Router $router)
    {


        //vista
        $router->render('paginas/nosotros', [
            'titulo' => 'Nosotros'
        ]);
    }

    public static function tienda( Router $router )
    {


        //vista
        $router->render('paginas/tienda', [
            'titulo' => 'Tienda'
        ]);
    }

    public static function contacto( Router $router )
    {


        //vista
        $router->render('paginas/contacto', [
            'titulo' => 'Contacto'
        ]);
    }
}
