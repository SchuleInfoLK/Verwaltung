<?php
require_once "config.php";
require_once "session.php";
$error = '';
#session_start();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email)) {
        $error .= '<p class="error"> Bitte eine E-Mail angeben</p>';
    }
    if (empty($password)) {
        $error .= '<p class="error"> Bitte Passwort eingeben</p>';
    }
    if(empty($error)){
        if($query = $db->prepare("SELECT * FROM users WHERE email =?")){
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            if($row){
                if(password_verify($password, $row['password'])){
                    $_SESSION["userid"] = $row['id'];
                    $_SESSION["user"] = $row;
                    header("Location: ../php/welcome.php");
                    exit;
                }else{
                    $error .= '<p class="error"> E-Mail oder Kennwort falsch.</p>'; #Falsches Passwort
                }
            }else{
                $error .= '<p class="error"> E-Mail oder Kennwort falsch.</p>'; #Falsche E-Mail
            }
        }
        $query->close();
    }
    mysqli_close($db);
}
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Anmeldung</title>
        <link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css" />
        <link rel="icon" type="image/png" href="../images/icon.png">
    </head>
    <body>
        <!--<header>
            <h1>Login</h1>
        </header>-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="loginbody">
                        <form action="" method="post">
                            <div class="form-group">
                                <h1>Login</h1>
                            </div>
                            <div class="form-group">
                                <!-- <label>E-Mail Adresse</label> -->
                                <input type="email" name="email" class="form-control" placeholder="E-Mail" required=""  oninvalid="this.setCustomValidity('Bitte eine gültige E-Mail eingeben')" oninput="setCustomValidity('')"/>
                            </div>
                            <div class="form-group">
                                <!-- <label>Passwort</label> -->
                                <input type="password" name="password" class="form-control" required="" placeholder="Passwort" oninvalid="this.setCustomValidity('Bitte ein Passwort eingeben')" oninput="setCustomValidity('')">
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn-primary" value="Anmelden">
                            </div>
                            <div id="changelog">
                            <p>Noch kein Konto? </br><a href="register.php">Hier registrieren</a></p>
                            </div>
                            <br>
                            <div>
                                <?php echo $error; ?>   
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
