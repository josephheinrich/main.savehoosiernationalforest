<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "vendor/autoload.php";
include 'include.php';

if (isset($_POST['subscribe'])) {
    if ($_POST['email'] == "") {
        header("Location: index.php");
        exit;
    }
    else {
        //connect to database
        doDB();

        //check that email is in list
        emailChecker($_POST['email']);

        //get number of results and do action
        if (mysqli_num_rows($check_res) < 1) {
        //free result
        mysqli_free_result($check_res);

        //add record
        $add_sql = "INSERT INTO subscribers (email)
        VALUES('".$safe_email."')";
        $add_res = mysqli_query($mysqli, $add_sql)
        or die(mysqli_error($mysqli));
        $display_block = "<div class='input-group mb-3 mt-5 container newsletter'><p class='newsletter-info'>Thanks for signing up!</p></div>";
        $email_block = <<<EMAILBLOCK
        <html lang="en">
        <head>
            <title>Thanks for signing up!</title>
        </head>
            <body bgcolor="#f4f4f4">
                <div style="margin: 10px; padding: 10px 10px 20px 10px;">
                    <div style="position: relative;
                    margin: 0 auto;">
                        <a href="https://savehoosiernationalforest.com" target="_blank" style="text-decoration: none; color: inherit">

                            <div style="display: block; 
                            letter-spacing: 2px; 
                            font-weight: 200;
                            color: #000000;
                            font-size: 30px;
                            height: 50px;
                            margin-left: 0.4rem; text-align: center;">
                                <span style="text-align: center; color: #000000;">Save<span style="letter-spacing: 1px;
                                font-weight: bold;">HNF</span></span>
                            </div>
                        </a>
                    </div>


                    <div>
                        <h1 style="text-align:center; color: #000000;">
                            Thanks for signing up!
                        </h1>
                        <h3 style="text-align:center; margin-top: 3rem; color: #000000;">
                            Check us out on <a href="https://www.facebook.com/groups/296704458944200" target="_blank">Facebook</a> and stay tuned for upcoming events, press releases, and more.
                        </h3>
                    </div>
                </div>
            </body>
        </html>
        EMAILBLOCK;

        $mail = new PHPMailer();

        $mail->From     = "noreply@savehoosiernationalforest.com";
        $mail->FromName = "Save Hoosier National Forest";
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);
        $mail->Subject  = "Thanks for signing up to the SaveHNF newsletter!";
        $mail->Body     = $email_block;

        try {
            $mail->send();
    
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        //close connection to MySQL
        mysqli_close($mysqli);
        } else {
            //print failure message
            $display_block = "<div class='input-group mb-3 mt-5 container newsletter'><p class='newsletter-info'>You're already subscribed!</p></div>";
        }
    }
} else {
    echo "failure";
}
?>