
<?php
session_start();
    //controllo file sia arrivato correttamente

        $file = $_FILES["file"];
        $user = $_SESSION['session_user'];
        $idutente = $_SESSION['id_user'];
        // check  se il file è arrivato correttamente
    $uploadDir = $_POST["directory"]; // /var/www/html/Data/LucaDaniel   /var/www/html/Data/LucaDaniel/5

       if(UPLOAD_ERR_OK == $file["error"]){

            // PARTE UPLOAD
            //check che non sia già presente il file
            //apertura percorso
            $esito = "Successo";
            $folder = opendir($uploadDir."/");
            while ($f = readdir($folder)) {
                if (is_file($uploadDir."/" . $f)) {
                    #CONTROLLO SOLO I FILE
                    if ($f == $file["name"]) {
                        $esito= "Errore";
                    }
                }
            }
            $folder = closedir($folder);

            //echo $esito;
            if($esito == "Successo") {
                $fileName = basename($file['name']);
                move_uploaded_file($file['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $fileName);
                $messaggio = "L'operazione di insertimento del file ".$file['name']." è andata a buon fine";
                header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
            }else{
                $messaggio = "L'operazione di insertimento del file ".$file['name']." è fallita";
                header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
            }
        }else{  // se errore ritorna subito nella pagina precedente
           $messaggio = "L'operazione di insertimento del file ".$file['name']." è fallita";
           header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
        }

?>