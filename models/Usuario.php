<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion', 'email', 'password', 'confirmado', 'token', 'admin'];

    public $id;
    public $cedula;
    public $nombre;
    public $apellido;
    public $telefono;
    public $direccion;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $confirmado;
    public $token;
    public $admin;
    public $mascotaId;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cedula = $args['cedula'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? 0;
    }

    // Validar el Login de Usuarios
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas;
    }


    // Validación para cuentas nuevas
    public function validar_cuenta()
    {
        if (!$this->cedula) {
            self::$alertas['error'][] = 'la Cedula es Obligatoria';
        }
        if (strlen($this->cedula) !== 8 && strlen($this->cedula) !== 10) {
            self::$alertas['error'][] = 'la Cedula debe ser de 8 o 10 Digitos';
        }
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Telefono es Obligatorio';
        }
        if (strlen($this->telefono) !== 10) {
            self::$alertas['error'][] = 'Telefono no valido';
        }
        if (!$this->direccion) {
            self::$alertas['error'][] = 'La direccion es Obligatoria';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail()
    {
        //validamos que se escriba algo
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        //validamos que este sea un email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    //para validar perfil
    public function validar_perfil(): array
    {
        if (!$this->cedula) {
            self::$alertas['error'][] = 'la Cedula es Obligatoria';
        }
        if (strlen($this->cedula) !== 8 && strlen($this->cedula) !== 10) {
            self::$alertas['error'][] = 'la Cedula debe ser de 8 o 10 Digitos';
        }
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Telefono es Obligatorio';
        }
        if (strlen($this->telefono) !== 10) {
            self::$alertas['error'][] = 'Telefono no valido';
        }
        if (!$this->direccion) {
            self::$alertas['error'][] = 'La direccion es Obligatoria';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    //vamos a validar password actual y password nuevo
    public function nuevo_password(): array
    {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no Puede ir Vacio';
        }

        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no Puede ir Vacio';
        }

        //Validar longitud de caracteres del password
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password Nuevo debe ser de mas de 6 caracteres';
        }
        return self::$alertas;
    }

    //Comprobar el password
    public function comprobar_password(): bool
    {
        return password_verify($this->password_actual, $this->password);
    }

    // Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken(): void
    {
        $this->token = uniqid();
    }
}
