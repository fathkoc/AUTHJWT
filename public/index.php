<?php
header("Content-Type: application/json");

include_once '../controllers/UserController.php';

$method = $_SERVER['REQUEST_METHOD'];
$userController = new UserController();

switch ($method) {
    case 'POST':
        
        $data = json_decode(file_get_contents("php://input"));
        echo $userController->createUser($data->name, $data->email, $data->password);
        break;

    case 'GET':
        
        echo $userController->getUsers();
        break;

    case 'PUT':
       
        $data = json_decode(file_get_contents("php://input"));
        echo $userController->updateUser($data->id, $data->name, $data->email);
        break;

    case 'DELETE':
      
        $data = json_decode(file_get_contents("php://input"));
        echo $userController->deleteUser($data->id);
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}

