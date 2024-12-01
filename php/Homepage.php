<?php
session_start();

if(!isset($_SESSION["userid"]) || $_SESSION["userid"] !== false){

}else{
    header("location: login.php");
   exit;
}
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/data.js"></script>
        <link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css" />
        <title>Home</title>
        <link rel="icon" type="image/jpg"
              href="../pictures/icon.png">
    </head>
    <body>
        <header>
            <h1> Homepage &#160 &#160 &#160 &#160 &#160</h1>

            <select id="mainselect">
                <option value="(Auswahl)" selected ="selected">Home</option>
                <option value="..//html/not_available.html">Wetterkarte</option>
            </select>

            <input type="submit" name="submit" class="btn-primary" value="Abmelden" id="logout">
        </header>

        <main>
            <p>Test</p>
            <a href="../php/logout.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Abmelden</a>
        </main>

        <footer>
            <p>
                <a href="../html/Impressum.html">Impressum</a>
            </p>
            <p>&copy; 2024 Philipp Uhlendorf</p>
            <p>
                <a href="../html/Datenschutz.html">Datenschutz</a>
            </p>
        </footer>
    
        <script>
            const Auswahl = document.getElementById("mainselect");
            Auswahl.addEventListener("change", function(){
             if(Auswahl.value != "(Auswahl)")
             location.href =Auswahl.value;})  

            const logoutb = document.getElementById('logout');
            logoutb.addEventListener("click", sendenlogout);
        </script>
    </body>
</html>
