<?php
session_start();

// steps: controllare che la cartella sia presente - in base a quello modificare + mex success o mandare mex errore

$user = $_SESSION['session_user'];
$esito = "Errore";
if( (isset($_POST["oldname"])) && (isset($_POST["newname"]))) {
    $oldname = $_POST["oldname"];
    $newname = $_POST["newname"];

    $Dir = $_POST["directory"]; // /var/www/html/Data/LucaDaniel   /var/www/html/Data/LucaDaniel/5

    $Directory = $Dir. "/";
    // controllo che new name non è già usato
    $problem = true;

    $folder = opendir($Directory);
    while ($fold = readdir($folder)) {
        if (is_dir($Directory . $fold)) {
            #CONTROLLO SOLO I FOLDER
            if ($fold == $newname) {
                #NEW NAME GIà OCCUPATO
                $problem=false;
            }
        }
    }
    $folder = closedir($folder);

    if($problem){
        $folder = opendir($Directory);
        while ($fold = readdir($folder)) {
            if (is_dir($Directory . $fold)) {
                #CONTROLLO SOLO I FOLDER
                if ($fold == $oldname) {
                    #FOLDER TROVATO
                    if (rename($Directory . $fold, $Directory . $newname)) {
                        $esito = "Successo";
                    }
                }
            }
        }
        $folder = closedir($folder);
    }


}
header("Location: http://serverwebuni.ns0.it:580/dashboard.php?operazione=".$esito."&currentdir=".$Dir);
?>