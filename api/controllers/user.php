<?php 

include '../../db/conn.php';

class UsersController {
    //register user
    public function registerUser($fname,$lname, $email, $password){
        global $con;
        $sql = ("select * from users where email='$email'");
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0){
            echo json_encode('exist');
            return false;
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_id = uniqid();
            $stmt = $con->prepare("insert into users (id, first_name,last_name,email,password) values (?,?,?,?,?)");
            $stmt->bind_param("sssss", $user_id, $fname, $lname, $email, $hashed_password);
            $stmt->execute();
            $stmt->close();
            $notes = json_encode(array());
            $stmt = $con->prepare('insert into notes (id, notes) values (?,?)');
            $stmt->bind_param("ss", $user_id, $notes);
            $stmt->execute();
            $stmt->close();
            $response = array(
                "status" => "success",
                "message" => "User registered successfully"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
    //login user
    public function loginUser($email, $password){
        global $con;
        $sql = "select * from users where email=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            //get the user data
            $user = $result->fetch_assoc();
            $hashed_password = $user['password'];
            //verify password
            if(password_verify($password, $hashed_password)){
                $_SESSION['user'] = $user;
                $response = array(
                    "user" => $user
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                header('Content-Type: application/json');
                echo json_encode('wrong-pass');
                return false;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode('invalid');
        }
    }
}

?>