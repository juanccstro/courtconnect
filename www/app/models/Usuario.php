<?php

require_once __DIR__ . '/BaseModel.php';

class Usuario extends BaseModel
{
    /**
     * Registrar usuario nuevo
     */
    public function registrar($nombre, $email, $password, $rol) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $hash, $rol]);
    }

    /**
     * Obtener usuario por email
     */
    public function obtenerPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";

        return $this->run($sql, [
            ':email' => $email
        ])->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Login de usuario
     */
    public function login($email, $password)
    {
        $usuario = $this->obtenerPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (!password_verify($password, $usuario['password'])) {
            return false;
        }

        $_SESSION['usuario'] = [
            'id'     => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email'  => $usuario['email'],
            'rol'    => $usuario['rol']
        ];

        return true;
    }

    /**
     * Obtener usuario por id
     */
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";

        return $this->run($sql, [
            ':id' => $id
        ])->fetch(PDO::FETCH_ASSOC);
    }
}
