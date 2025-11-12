<?php
class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrar($nombre, $email, $password, $rol) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $hash, $rol]);
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'rol' => $usuario['rol']
            ];
            return true;
        }
        return false;
    }
}
