<?php
/*
/ La clase Router se utiliza para manejar y administrar rutas en una aplicación web, 
permitiendo asociar funciones o métodos específicos a diferentes URL de la aplicación.
*/

namespace MVC;

class Router
{
    //toma dos argumentos: $url y $fn. Este método almacena la función $fn asociada a la URL $url en el array $rutasGet
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }


        if ( $fn ) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            //redireccionamos a una pagina 404
            header('Location: /404');
        }
    }

    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        //Utilizar el layout de acuerdo a la URL
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';

        if(str_contains($currentUrl, '/admin')) {
            //Si lo contiene usamos el layout para admin
            include_once __DIR__ . '/views/admin-layout.php';
        }else {
            //Si no lo contiene usamos el layout normal
            include_once __DIR__ . '/views/layout.php';
        }
    }
}