<?php
require_once __DIR__ . '/autoload.php';

// Inicializar controlador
$controller = new AppointmentController();

// Manejar solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = $_POST;
    }

    $action = $input['action'] ?? '';
    $id = $input['id'] ?? null;

    switch ($action) {
        case 'create':
            $result = $controller->create($input);
            echo json_encode($result);
            exit;

        case 'update':
            if ($id) {
                $result = $controller->update($id, $input);
                echo json_encode($result);
            } else {
                echo json_encode(['success' => false, 'errors' => ['ID requerido']]);
            }
            exit;

        case 'cancel':
            if ($id) {
                $result = $controller->cancel($id);
                echo json_encode($result);
            } else {
                echo json_encode(['success' => false, 'errors' => ['ID requerido']]);
            }
            exit;

        case 'delete':
            if ($id) {
                $result = $controller->delete($id);
                echo json_encode($result);
            } else {
                echo json_encode(['success' => false, 'errors' => ['ID requerido']]);
            }
            exit;

        case 'get':
            if ($id) {
                $appointment = $controller->show($id);
                echo json_encode(['success' => true, 'data' => $appointment]);
            } else {
                echo json_encode(['success' => false, 'errors' => ['ID requerido']]);
            }
            exit;
    }
}

// Si es GET, mostrar la vista
$appointments = $controller->index();
include __DIR__ . '/view/index.php';
