<?php
include '../.././db/conn.php';
include '../../controllers/noted.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$id = $_GET['id'];
$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$text = $data['text'];

$notesController = new NotesController;
$notesController->createNote($id, $title, $text);
?>