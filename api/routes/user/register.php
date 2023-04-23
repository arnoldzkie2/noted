<?php
include '../.././db/conn.php';
include '../../controllers/user.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$data = json_decode(file_get_contents('php://input'), true);
$fname = $data['first_name'];
$lname = $data['last_name'];
$email = $data['email'];
$password = $data['password'];
$usersController = new UsersController();
$usersController->registerUser($fname,$lname, $email, $password);
?>
