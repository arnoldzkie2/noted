<?php
include '../.././db/conn.php';
include '../../controllers/noted.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$id = $_GET['id'];
$note_id = $_GET['note_id'];
$notesController = new NotesController;
$notesController->deleteNote($id, $note_id);
?>