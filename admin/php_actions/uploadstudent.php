<?php
    session_start();
    include("../../includes/config.php");

    //Student Pic Upload
    if(isset($_POST['studentpic'])){
                                                
        $student = $_POST['student'];
        $filename = addslashes($_FILES['img']['name']);
        $tmpname = addslashes(file_get_contents($_FILES['img']['tmp_name']));
        $filetype = addslashes($_FILES['img']['type']);
        $target = "../../images/student_photo/";
        $targetpath = $target . $filename;
        
        
      
        $array = array('jpg', 'jpeg');
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
      
          if(!empty($filename)){
            move_uploaded_file($_FILES['img']['tmp_name'], $targetpath);
            if(in_array($ext, $array)){

                  $sql ="UPDATE students SET student_pic ='images/student_photo/$filename' where LRN_number = $student;";
                  $result =mysqli_query($conn, $sql);
                  if($result){
                        $_SESSION['message'] = "Profile Picture has been changed!";
                        $_SESSION['msg_type'] = "success";

                        header("location: ../students.php");
                  }
                    else{
                        $_SESSION['message'] = "Error Uploading Picture!";
                        $_SESSION['msg_type'] = "danger";

                        header("location: ../students.php");
                    }
            }
            else{
                $_SESSION['message'] = "Upload Only jpg or jpeg format";
                $_SESSION['msg_type'] = "warning";

                header("location: ../students.php");
            } 
        }
        else{
            $_SESSION['message'] = "Please select an image";
            $_SESSION['msg_type'] = "info";

            header("location: ../students.php");
          }

}
?>