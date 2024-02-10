<?php

namespace Controllers;

use Model\Mascota;
use Model\Cita;
use Model\CitaEditar;
use Model\Hora;

class ApiusuarioController
{
    /**************************************************AREA DE MASCOTAS************************************************************/
    public static function guardarmascota()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();
            $mascota = new Mascota($_POST);
            $mascota->propietarioId = $_SESSION['id'];

            //Guardamos en la base de datos
            $mascota->guardar();
            //creamos respuesta
            $respuesta = [
                'tipo' => 'exito',
                'mensaje' => 'Registro Creado Correctamente',
                'propietarioId' => $_SESSION['id']
            ];

            echo json_encode($respuesta);
        }
    }

    public static function vermascotas()
    {
        session_start();

        //consultamos para luego evniar la peticion
        $mascotas = Mascota::belongsTo('propietarioId', $_SESSION['id']);

        //Enviamos la respuesta
        echo json_encode(['mascotas' => $mascotas]);
    }

    public static function editarMascota()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $mascota = new Mascota($_POST);
            $mascota->propietarioId = $_SESSION['id'];

            //llamamos metodo para eliminar la tarea de la BD
            $resultado = $mascota->guardar();

            $resultado = [
                'resultado' => $resultado,
                'tipo' => 'exito',
                'mensaje' => 'Se Edito Correctamente'
            ];

            echo json_encode($resultado);
        }
    }

    public static function eliminarMascota()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $mascota = new Mascota($_POST);
            $mascota->propietarioId = $_SESSION['id'];

            //llamamos metodo para eliminar la tarea de la BD
            $resultado = $mascota->eliminar();

            $resultado = [
                'resultado' => $resultado,
                'tipo' => 'exito',
                'mensaje' => 'Eliminado Correctamente'
            ];

            echo json_encode($resultado);
        }
    }
    /*****************************************************************************************************************************/


    /***********************************AREA DE CONSULTAS MEDICAS************************************************************/
    public static function verConsultas()
    {
        session_start();
        //LLamamos solo las citas del usuario
        $citasUsuario = Cita::belongsTo('usuario_id', $_SESSION['id']);

        // //instanciamos la clase Cita y la de Mascotas
        foreach ($citasUsuario as $citasU) {
            $citasU->horaID = Hora::find($citasU->horaID);
            $citasU->mascota_id = Mascota::find($citasU->mascota_id);
        }

        echo json_encode(['citasUsuario' => $citasUsuario]);
    }

    public static function crearConsulta()
    {
        $citas = new Cita;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Iniciamos sesión
            session_start();

            // Para proteger
            isAuth();

            if ($_POST['usuario_id']) {
                //el usuario esta creando la cita
                $citas->sincronizar($_POST);
            } else {
                //el admin esta creando la cita por el usuario
                $citas->sincronizar($_POST);
                $citas->usuario_id = $_SESSION['id'];
            }

            // Verificamos si la hora tomada existe en la base de datos
            $existeHora = Cita::whereDate('horaID', $citas->horaID, 'fecha', $_POST['fecha']);

            if (!empty($existeHora)) {
                $resultadoOC = [
                    'tipo' => 'error',
                    'mensaje' => 'Hora ya tomada'
                ];
                echo json_encode($resultadoOC);
            } else {
                $resultado = $citas->guardar();

                if ($resultado) {
                    $resultado = [
                        'resultado' => $resultado,
                        'tipo' => 'exito',
                        'mensaje' => 'Cita creada correctamente'
                    ];
                    echo json_encode($resultado);
                } else {
                    $resultado = [
                        'resultado' => $resultado,
                        'tipo' => 'error',
                        'mensaje' => 'Error al crear la cita'
                    ];
                    echo json_encode($resultado);
                }
            }
        }
    }

    //para editar cita
    public static function editarConsulta()
    {
        $citas = new CitaEditar;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $citas->sincronizar($_POST);

            // verificamos si la hora tomada existe en la base de datos
            $existeHora = CitaEditar::whereDate('horaID', $citas->horaID, 'fecha', $_POST['fecha']);

            if ($existeHora) {
                $resultadoOC = [
                    'tipo' => 'error',
                    'mensaje' => 'Hora ya tomada'
                ];

                echo json_encode($resultadoOC);
            } else {

                // //llamamos metodo para editar la tarea de la BD
                $resultado = $citas->guardar();
                $resultado = [
                    'resultado' => $resultado,
                    'tipo' => 'exito',
                    'mensaje' => 'Se Edito Correctamente'
                ];

                echo json_encode($resultado);
            }
        }
    }

    public static function borrarConsulta()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $citas = new Cita($_POST);

            //llamamos metodo para eliminar la tarea de la BD
            $resultado = $citas->eliminar();

            $resultado = [
                'resultado' => $resultado,
                'tipo' => 'exito',
                'mensaje' => 'Eliminado Correctamente'
            ];

            echo json_encode($resultado);
        }
    }

    //Para mostrar las horas disponibles
    public static function verHorasyMascotas()
    {
        session_start();

        //para protejer
        isAuth();

        date_default_timezone_set('America/Bogota');

        // Capturar la fecha desde $_GET
        $fechaSeleccionada = $_GET['fecha'];
        $session = $_SESSION['id'];

        $consulta = "SELECT h.* FROM horas h ";
        $consulta .= " LEFT JOIN citas c ON h.id = c.horaID AND c.fecha = '${fechaSeleccionada}' ";
        $consulta .= " WHERE c.horaID IS NULL; ";
        // //llamamos a las horas y hacemos la consulta
        $horas = Hora::SQL($consulta);

        //Consulta
        $consultaM = "SELECT * FROM mascotas ";
        $consultaM .= " WHERE propietarioId = '${session}'
        AND id NOT IN (
          SELECT mascota_id
          FROM citas
      ) ";
        $mascotas = Mascota::SQL($consultaM);
        echo json_encode(['horasDisponibles' => $horas, 'mascotasDisponibles' => $mascotas]);
    }

    //Para mostrar las horas disponibles
    public static function verHorasModal()
    {
        session_start();

        //para protejer
        isAuth();

        date_default_timezone_set('America/Bogota');

        // Capturar la fecha desde $_GET
        $fechaSeleccionada = $_GET['fecha'];

        $consulta = "SELECT h.* FROM horas h ";
        $consulta .= " LEFT JOIN citas c ON h.id = c.horaID AND c.fecha = '${fechaSeleccionada}' ";
        $consulta .= " WHERE c.horaID IS NULL; ";
        // //llamamos a las horas 
        $horas = Hora::SQL($consulta);

        echo json_encode(['horasDisponibles' => $horas]);
    }
    /**************************************************************************************************************************/

    /***********************************AREA DE PELUQUERIA*********************************************************************/
    /**************************************************************************************************************************/
}
