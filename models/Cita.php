<?php

namespace Model;

class Cita extends ActiveRecord
{
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'mascota_id', 'fecha', 'horaID', 'motivo', 'usuario_id'];

    public $id;
    public $mascota_id;
    public $fecha;
    public $horaID;
    public $motivo;
    public $usuario_id;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->mascota_id['mascota_id'] ?? '';
        $this->fecha['fecha'] ?? '';
        $this->horaID['horaID'] ?? 0;
        $this->motivo['motivo'] ?? '';
        $this->usuario_id['usuario_id'] ?? 0;
    }
}
