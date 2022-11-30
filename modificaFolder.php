<?php
session_start();

// steps: controllare che la cartella sia presente - in base a quello modificare + mex success o mandare mex errore

$user = $_SESSION['session_user'];
$esito = "Errore";
if( (isset($_POST["oldname"])) && (isset($_POST["newname"]))) {
    $oldname = $_POST["oldname"];
    $newname = $_POST["newname"];

    echo $oldname . "<pre/>";
    echo $newname . "<pre/>";

    $Directory = __DIR__ . "/Data/" . $user . "/";
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
header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php?operazione=".$esito);
?>