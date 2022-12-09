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
                $ext = explode(".", $file);
                 $estensione = ".".$ext[count($ext)-1];
                if($estensione==".txt"){
                    $file_url = $Directory.$file;
                    header('Content-Type: application/octet-stream');
                    header("Content-Transfer-Encoding: utf-8");
                    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
                    readfile($file_url);
                }else{
                    $file_url = $Directory.$file;
                    header('Content-Type: application/octet-stream');
                    header("Content-Transfer-Encoding: Binary");
                    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
                    readfile($file_url);

                }
            }
        }
    }

    $folder = closedir($folder);
    if($esito =="Errore") {
        header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php?operazione=" . $esito);
    }
}




?>