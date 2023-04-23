<?php
include '../.././db/conn.php';
include '../../controllers/noted.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$id = $_GET['id'];
$note_id = $_GET['note_id'];
$data = json_decode(file_get_contents('php://input'), true);
$text = $data['text'];
$title = $data['title'];
$notesController = new NotesController;
$notesController->updateNote($id, $note_id, $text, $title);
?>