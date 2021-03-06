<?php
session_start();
include("../../includes/config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if(isset($_GET['deny'])){

    //Update the user status to denied
    $id = $_GET['deny'];
    $conn->query("UPDATE users SET status='DENIED' WHERE userid='$id' ") or die($conn->error);

    // Send Credentials
    $fetch_user = "SELECT *  FROM users WHERE userid='$id';";
            $result = $conn->query($fetch_user);
            $row = $result->fetch_assoc();
            
            $fname = $row['fname'];
            $mname = $row['mname'];
            $lname = $row['lname'];
            $username = $row['username'];
            $userEmail = $row['email'];

            $full_name = $fname . " " . $mname . ". " . $lname;

    $name = $full_name;
    $email = $userEmail;
    $subject = "ENHS New User Confirmation!";
    $body = "Good day! " . $name . 
    ". Thank you for registering to the Estancia National High School Miscellaneous Payment System. For security reasons, we are sorry to inform you that we did not see enough details about you that you are currently employed as a faculty of this institution thus we made a decision to temporarily hold your account until further notice. \nFor more information please contact us.";

    require '../libraries/PHPMailer/PHPMailer.php'; 
    require '../libraries/PHPMailer/SMTP.php'; 
    require '../libraries/PHPMailer/Exception.php';

    $mail = new PHPMailer();

    try {
																				
        $mail->setFrom('no-reply@howcode.org', 'ENHS Payment System');
        $mail->addAddress($email, $name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        /* SMTP parameters. */
        
        /* Tells PHPMailer to use SMTP. */
        $mail->isSMTP();
        
        /* SMTP server address. */
        $mail->Host = 'smtp.gmail.com';

        /* Use SMTP authentication. */
        $mail->SMTPAuth = TRUE;
        
        /* Set the encryption system. */
        $mail->SMTPSecure = 'ssl';
        
        /* SMTP authentication username. */
        $mail->Username = 'stevenskie9090@gmail.com';
        
        /* SMTP authentication password. */
        $mail->Password = 'mcsoingviamkbnel';
        
        /* Set the SMTP port. */
        $mail->Port = 465;
        
        /* Finally send the mail. */
        $mail->send();
    }
    catch (Exception $e)
    {
        echo $e->errorMessage();
    }
    catch (\Exception $e)
    {
        echo $e->getMessage();
    }

    $_SESSION['message'] = "You denied " . $full_name . " from accessing the system.";
    $_SESSION['msg_type'] = "danger";

    header("location: ../index.php");
}
