<?php
include '../.././db/conn.php';
include '../../controllers/noted.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$id = $_GET['id'];
$notesController = new NotesController;
$notesController->getAllNoteS($id);
?>