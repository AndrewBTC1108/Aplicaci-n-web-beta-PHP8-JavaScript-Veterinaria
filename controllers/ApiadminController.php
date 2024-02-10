<?php

namespace Controllers;

use Model\Cita;
use Model\Hora;
use Model\Mascota;
use Model\Usuario;

class ApiadminController
{
    /***********************************AREA DE CONSULTAS MEDICAS************************************************************/
    public static function TotalConsultas()
    {
        session_start();

        //para protejer
        isAuth();

        date_default_timezone_set('America/Bogota');

        // Capturar la fecha desde $_GET
        $fechaSeleccionada = $_GET['fecha'];

        //Hacemos consulta a las citas si se han tomado
        $consulta = "SELECT * FROM citas WHERE fecha = '${fechaSeleccionada}'";
        $consultas = Cita::SQL($consulta);

        foreach ($consultas as $consulta) {
            $consulta->horaID =  Hora::find($consulta->horaID);
            $consulta->mascota_id = Mascota::find($consulta->mascota_id);
            $consulta->usuario_id = Usuario::find($consulta->usuario_id);
        }

        echo json_encode(['consultas' => $consultas]);
    }

    public static function TotalUsuarios()
    {
        session_start();

        //para protejer
        isAuth();

        //llamamos a los usuarios
        $usuarios = Usuario::all('ASC');

        echo json_encode($usuarios);
    }

    public static function MascotasUsuario()
    {

        session_start();

        //para protejer
        isAuth();

        // Capturar el id usuario desde $_GET
        $UsuarioID = $_GET['usuario_id'];

        // //Consulta
        $consultaM = "SELECT * FROM mascotas ";
        $consultaM .= " WHERE propietarioId = '${UsuarioID}'
                AND id NOT IN (
                  SELECT mascota_id
                  FROM citas
              ) ";
        $mascotas = Mascota::SQL($consultaM);


        echo json_encode(['mascotasDisponibles' => $mascotas]);
    }
    /**************************************************************************************************************************/

    /********************************************AREA DE PELUQUERIA************************************************************/
    /**************************************************************************************************************************/
}
