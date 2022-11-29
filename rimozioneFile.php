<?php
session_start();
$user = $_SESSION['session_user'];
if(isset($_POST["nomeFile"])) {
    $nomefile = $_POST["nomeFile"];
//apro la cartella user
    $Directory = __DIR__ . "/Data/" . $user . "/";
    $trovato = false;

//apertura percorso
    $folder = opendir($Directory);
    while ($file = readdir($folder)) {
        #echo $file."<br/>";
        if (is_file($Directory . $file)) {
            #CONTROLLO SOLO I FILE
            #echo $file."<br/>";
            if ($file == $nomefile) {
                #CANCELLO IL FILE
                @unlink($Directory . $file);
                $trovato = true;
            }
        }
    }

    $folder = closedir($folder);

    if ($trovato) {
        // avviso ok
    } else {
        // avviso negativo
    }
}
header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php? ");
?>