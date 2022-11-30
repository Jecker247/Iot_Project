<?php
session_start();
$user = $_SESSION['session_user'];
if(isset($_POST["downloadFileName"])) {
    $nomefile = $_POST["downloadFileName"];
    //apro la cartella user
    $Directory = __DIR__ . "/Data/" . $user . "/";
    $esito = "Errore";
    //apertura percorso
    $folder = opendir($Directory);
    while ($file = readdir($folder)) {
        if (is_file($Directory . $file)) {
            #CONTROLLO SOLO I FILE
            if ($file == $nomefile) {
                #TROVATO
                $esito = "Successo";
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$file");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");
                readfile($file);
            }
        }
    }

    $folder = closedir($folder);
    if($esito =="Errore") {
        header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php?operazione=" . $esito);
    }
}




?>