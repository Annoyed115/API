<?php
require_once '../config/database.php';

class AuthController {
    public static function register($username, $password) {
        global $pdo;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);
            return ["status" => "success", "message" => "Usuario registrado exitosamente"];
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "Error: " . $e->getMessage()];
        }
    }

    public static function login($username, $password) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return ["status" => "success", "message" => "Autenticación exitosa"];
        } else {
            return ["status" => "error", "message" => "Usuario o contraseña incorrectos"];
        }
    }
}
?>
