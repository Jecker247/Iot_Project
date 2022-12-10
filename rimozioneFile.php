<?php
session_start();
$user = $_SESSION['session_user'];

$Dir = $_POST["directory"]; // /var/www/html/Data/LucaDaniel   /var/www/html/Data/LucaDaniel/5

if(isset($_POST["nomeFile"])) {
    $nomefile = $_POST["nomeFile"];
//apro la cartella user
    //$Directory = __DIR__ . "/Data/" . $user . "/";
    $trovato = false;

//apertura percorso
    $folder = opendir($Dir."/");
    while ($file = readdir($folder)) {
        #echo $file."<br/>";
        if (is_file($Dir."/" . $file)) {
            #CONTROLLO SOLO I FILE
            #echo $file."<br/>";
            if ($file == $nomefile) {
                #CANCELLO IL FILE
                @unlink($Dir."/" . $file);
                $trovato = true;
            }
        }
    }

    $folder = closedir($folder);

    if ($trovato) {
        // avviso ok
        $esito = "Successo";
        header("Location: http://serverwebuni.ns0.it:580/dashboard.php?operazione=".$esito."&currentdir=".$Dir);
    } else {
        // avviso negativo
        $esito= "Errore";
        header("Location: http://serverwebuni.ns0.it:580/dashboard.php?operazione=".$esito."&currentdir=".$Dir);
    }
}

?>