<?php

namespace Model;

class Mascota extends ActiveRecord
{
    protected static $tabla = 'mascotas';
    protected static $columnasDB = ['id', 'nombre', 'nacimiento', 'especie', 'raza', 'color', 'sexo', 'propietarioId'];

    public $id;
    public $nombre;
    public $nacimiento;
    public $especie;
    public $raza;
    public $color;
    public $sexo;
    public $propietarioId;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->nacimiento = $args['nacimiento'] ?? '';
        $this->especie = $args['especie'] ?? '';
        $this->raza = $args['raza'] ?? '';
        $this->color = $args['color'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? 0;
    }
}
