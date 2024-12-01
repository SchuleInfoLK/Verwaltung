<?php
require_once "config.php";
require_once "session.php";

$error = ''; // Initialize the $error variable
$success = ''; // Initialize the $success variable
header('Content-Type: text/html; charset=utf-8');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if($query = $db->prepare("SELECT * FROM users WHERE email = ?")){
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();
        if($query->num_rows > 0){
            $error .= '<p class="error"> Diese E-Mail Adresse ist schon registriert.</p>';
        } else {
            if(strlen($password) < 6){
                $error .= '<p class="error"> Passwort muss mindestens 6 Zeichen enthalten.</p>';
            }
            if(empty($confirm_password)){
                $error .= '<p class="error"> Bitte Wiederholen Sie ihr Passwort.</p>';
            } else {
                if(empty($error) && ($password != $confirm_password)){
                    $error .= '<p class="error"> Passwörter stimmen nicht überein.</p>';
                }
            }
            if(empty($error)){
                $insertQuery = $db->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
                $insertQuery->bind_param("sss", $fullname, $email, $password_hash);
                $result = $insertQuery->execute();
                if($result){
                    $success = '<p class="success"> Sie haben sich erfolgreich registriert! <br> Weiterleitung . . . </p>';
                    };
                } else {
                    $error .= '<p class="error"> Es ist ein Fehler aufgetreten!</p>';
                }
            }
        }
        $query->close();
    }
    if (isset($insertQuery)) {
        $insertQuery->close();
    }
    mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrieren</title>
        <link rel="icon" type="image/jpg" href="../images/icon.jpg">
        <link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css" />
    </head>
    <body>
        <!--header>
            <h1>Registrieren</h1>
        </header>-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="regbody">
                        <!--<div id="form-group">
                        <h2>Registrieren</h2>
                        <p>Bitte geben Sie ihre Daten zum Erstellen eines Kontos an</p>
                        </div>-->
                        <form action="" method="post">
                            <div class="form-group">
                                <h1>Registrieren</h1>
                            </div>
                            <div class="form-group">
                                <!--<label>Vor- und Zuname</label>-->
                                <input type="text" name="name" class="form-control" placeholder="Vor- und Nachname" required>
                            </div>
                            <div class="form-group">
                                <!--<label>E-Mail Adresse</label>-->
                                <input type="email" name="email" class="form-control" placeholder="E-Mail" />
                            </div>
                            <div class="form-group">
                                <!--<label>Passwort</label>-->
                                <input type="password" name="password" class="form-control" placeholder="Passwort">
                            </div>
                            <div class="form-group">
                                <!--<label>Passwort wiederholen</label>-->
                                <input type="password" name="confirm_password" class="form-control" placeholder="Passwort wiederholen">
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn-primary" value="Registrieren">
                            </div>
                            <div id="changelog">
                            <p>Bereits ein Konto? <br><a href="login.php">Hier anmelden</a></p>
                            </div>
                            <br>
                            <div>
                            <?php echo isset($success) ? $success : ''; 
                                echo $error; 
                                if($result = $success){   
                                header("Refresh:1; url= ../php/login.php");
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
