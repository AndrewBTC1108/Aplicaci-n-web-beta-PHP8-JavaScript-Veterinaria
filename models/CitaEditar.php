<?php

namespace Model;

class CitaEditar extends ActiveRecord
{
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'horaID'];

    public $id;
    public $fecha;
    public $horaID;
}
