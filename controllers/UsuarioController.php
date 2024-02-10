<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;

class UsuarioController
{
    public static function index(Router $router)
    {

        //arrancamos sesion
        session_start();

        //proteger la url
        isAuth();

        // Render a la vista 
        $router->render('panelusuario/index', [
            'titulo' => 'Panel de usuario'
        ]);
    }

    //Registrar nuevas mascotas
    public static function registrar(Router $router)
    {
        //arrancamos sesion
        session_start();

        //proteger la url
        isAuth();

        // Render a la vista 
        $router->render('panelusuario/nuevamascota', [
            'titulo' => 'Registrar Nueva Mascota'
        ]);
    }


    //Para ver nuestro perfil
    public static function perfil(Router $router)
    {
        //array vacio para ir llenando con alertas
        $alertas = [];

        session_start();

        //para protejer
        isAuth();

        //vamos a buscar el usuario que haya iniciado sesion
        //para luego pasarlo a la vista

        $usuario = Usuario::find($_SESSION['id']);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            //validamos que el arreglo alertas este vacio
            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    //Mensaje de error
                    Usuario::setAlerta('error', 'Email no valido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();
                } else {
                    //guardarel registro
                    //guardar usuario
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();

                    //procedemos a reescribir la sesion con los nuevos datos
                    //ya que de no hacerce la sesion permanecera con los datos
                    //antiuguos de la instacnia de usuario
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['apellido'] = $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                }
            }
        }

        $router->render('panelusuario/perfil', [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    //para cambiar la contraseña
    public static function cambiar_password(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //con esto vamos a identificar al usuario que desea cambiar su password
            $usuario = Usuario::find($_SESSION['id']);
            // debuguear($usuario);

            //Sicnronizamos con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if (empty($alertas)) {
                //retorna true o false
                $resultado = $usuario->comprobar_password();

                if ($resultado) {
                    //Asignar el nuevo password
                    //Asignamos el password nuevo al password actual
                    $usuario->password = $usuario->password_nuevo;

                    //Eliminamos propiedades no necesarias
                    //Primero eliminamos el password actual
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //hashear el nuevo password
                    $usuario->hashPassword();

                    //Actualizar 
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = $usuario->getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('panelusuario/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);
    }


    //Ver Mascotas
    public static function mascotas(Router $router)
    {
        session_start();
        isAuth();

        $router->render('panelusuario/mascotas', [
            'titulo' => 'Mis Mascotas'
        ]);
    }


    //Crear Consultas o Citas
    public static function citas(Router $router)
    {

        $router->render('panelusuario/cita', [
            'titulo' => 'Crear Cita'
        ]);
    }
}
