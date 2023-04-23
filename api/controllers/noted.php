<?php 

include '../../db/conn.php';

class NotesController{

    public function getAllNotes($id){
        //find the user using id that pass in as parameter
        global $con;
        $stmt = $con->prepare('Select * from notes where id=?');
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            $row = $result->fetch_assoc();
            $notes = json_decode($row['notes'], true);
            $stmt->close();
            //pass the notes array of the user
            header('Content-Type: application/json');
            $response = array(
                'notes' => $notes
            );
            echo json_encode($response);
        } else {
            header("Content-Type: application/json");
            echo json_encode('No user found');
        }
    }

    public function createNote($id, $title, $text){
        global $con;
        //find the user 
        $stmt = $con->prepare("select * from notes where id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if(!$result){
            header('Content-type: application/json');
            echo json_encode("no user found!");
            return false;
        }
        $row = $result->fetch_assoc();
        // decode the notes array to edit
        $notes = json_decode($row['notes'], true);
        // let's create a new notes array of object
        if(!$title){
            return false;
        }
        $unique = uniqid();
        $new_note = array(
            "note_id" => $unique,
            "title" => $title,
            "text" => $text
        );
        array_push($notes, $new_note);    
        //update the note
        $notes = json_encode($notes);
        $stmt = $con->prepare('update notes set notes=? where id=?');
        $stmt->bind_param("ss", $notes, $id);
        $stmt->execute();
        $stmt->close();
        $response = array(
            "success" => true,
            "data" => $new_note
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }



    public function deleteNote($id, $note_id){
        global $con;

        //find the user using the id parameter
        $stmt = $con->prepare('select * from notes where id=?');
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if(!$result){
            header('Content-type: application/json');
            echo json_encode("no user found");
            return false;
        }
        $row = $result->fetch_assoc();
        //decode the notes array to edit
        $notes = json_decode($row['notes']);
        $index = -1;
        foreach($notes as $i => $note){
            if($note->note_id == $note_id){
                $index = $i;
                break;
            }
        }
        if($index >=0){
            array_splice($notes, $index, 1);
        } else {
            $response = array(
                "msg" => "no notes that contains that id",
            );
            header('Content-type: application/json');
            echo json_encode($response);
            return false;
        }
        $notes_json = json_encode($notes);
        $stmt= $con->prepare("update notes set notes=? where id=?");
        $stmt->bind_param("ss", $notes_json, $id);
        $stmt->execute();
        $stmt->close();
        header('Content-type: application/json');
        $response = array(
            "success" => true,
        );
        echo json_encode($response);
    }
    
    public function updateNote($id, $note_id, $text, $title){
        //find the user in databse
        global $con;
        $stmt =$con->prepare('select * from notes where id=?');
        $stmt->bind_param("s", $id);
        $stmt->execute();
        //get the result
        $result = $stmt->get_result();
        if(!$result){
            header('content-type: application/json');
            echo json_encode('no user found');
            return false;
        }
        $row = $result->fetch_assoc();
        //decode the notes to edit
        $notes = json_decode($row['notes'], true);
        $index = -1;
        foreach($notes as $i => $note){
            if($note['note_id'] == $note_id){
                $index = $i;
                break;
            }
        }
        if($index != -1){
            $notes[$index]['text'] = $text;
            $notes[$index]['title'] = $title;
            $updated_notes = json_encode($notes);
            $stmt = $con->prepare("update notes set notes=? where id=?");
            $stmt->bind_param("ss",$updated_notes, $id);
            $stmt->execute();
            $stmt->close();
            header('content-type: application/json');
            $response = array(
                "success" => true
            );
            echo json_encode($response);
        }else {
            header('content-type: application/json');
            echo json_encode('notes not found');
        }
    }


}


?>