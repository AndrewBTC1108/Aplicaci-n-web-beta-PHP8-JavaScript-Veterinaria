<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\PaginasController;
use Controllers\UsuarioController;
use Controllers\ApiusuarioController;
use Controllers\DashboardController;
use Controllers\ApiadminController;

$router = new Router();//instanciamos

//login
// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

//Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

//Colocar el nuevo Password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);


//AREA PUBLICA
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/tienda', [PaginasController::class, 'tienda']);
$router->get('/contacto', [PaginasController::class, 'contacto']);


//Area de Administracion
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

//Api Admin
$router->get('/admin/TotalConsultas', [ApiadminController::class, 'TotalConsultas']);
$router->get('/admin/TotalUsuarios', [ApiadminController::class, 'TotalUsuarios']);
$router->get('/admin/TotalMascotas', [ApiadminController::class, 'MascotasUsuario']);

//Panel de Usuarios
$router->get('/principal', [UsuarioController::class, 'index']);//vista principal
$router->get('/nuevamascota', [UsuarioController::class, 'registrar']);//1Vista Registrar Mascota
$router->get('/perfil', [UsuarioController::class, 'perfil']);
$router->post('/perfil', [UsuarioController::class, 'perfil']);
$router->get('/cambiar-password', [UsuarioController::class, 'cambiar_password']);
$router->post('/cambiar-password', [UsuarioController::class, 'cambiar_password']);
$router->get('/mascotas', [UsuarioController::class, 'mascotas']);//2 VISTA VERMASCOTAS
$router->get('/cita', [UsuarioController::class, 'citas']);//3 VISTA CREAR CONSULTAS
// $router->post('/cita', [UsuarioController::class, 'citas']);


//API 
$router->post('/nuevamascota/guardar', [ApiusuarioController::class, 'guardarmascota']);//1 API REGISTRAR MASCOTA
$router->get('/mascotas/vermascotas', [ApiusuarioController::class, 'vermascotas']);//2 API VER MASCOTAS
$router->post('/mascotas/eliminarmascota', [ApiusuarioController::class, 'eliminarMascota']);//2 API EDITAR MASCOTAS
$router->post('/mascotas/editarmascota', [ApiusuarioController::class, 'editarMascota']);//2 API ELIMINAR MASCOTAS
$router->get('/citasU', [ApiusuarioController::class, 'verConsultas']); //3 API VER Consultas
$router->post('/cita/crearConsulta', [ApiusuarioController::class, 'crearConsulta']); //3 API CREAR CONSULTAS
$router->post('/citasU/editarC', [ApiusuarioController::class, 'editarConsulta']); //3 API EDITAR CITAS
$router->post('/citasU/borrarC', [ApiusuarioController::class, 'borrarConsulta']); //3 API eliminar CITAS
$router->get('/horasU', [ApiusuarioController::class, 'verHorasyMascotas']); //3 API PARA VER HORAS Y MASCOTAS
$router->get('/horasUModal', [ApiusuarioController::class, 'verHorasModal']);//3API PARA VER HORAS DEL MODAL



// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//comprobar las rutas
$router->comprobarRutas();