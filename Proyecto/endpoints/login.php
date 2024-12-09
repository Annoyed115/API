<?php
require_once '../controllers/AuthController.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['username']) && !empty($data['password'])) {
    $response = AuthController::login($data['username'], $data['password']);
    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "Faltan datos"]);
}
?>
