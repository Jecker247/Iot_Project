<?php
#Inizio Sessione
session_start();
# require del file dimensions e database php
require("./config/dimensions.php");
require_once("./config/database.php");

$MaxCaratteri = 22;
$FileNameModificato = False;
# settato a NULL nel caso non servisse
$FinalNameFileModify=null;
$file = $_FILES["file"];
$user = $_SESSION['session_user'];
# CONTROLLO se il file è arrivato correttamente
# UploadDir -> directory di lavoro attuale
$uploadDir = $_POST["directory"];

if(UPLOAD_ERR_OK == $file["error"]) {
    #UPLOAD WORKING
    $fileName = $file['name'];
    if (strlen($file['name']) > $MaxCaratteri) {
        $FileNameModify = $file['name'];
        #explode per ottenere la parte finale (estensione)
        $fileNameParts = explode('.', $FileNameModify);
        $ext = end($fileNameParts);
        #ottengo substring
        $fileSubstringModify = substr($FileNameModify, 0, $MaxCaratteri);
        #concateno Stringa File Name Modificata
        $FinalNameFileModify = $fileSubstringModify . "." . $ext;
        #$FinalNameFileModify variabile con stringa finale!
        $FileNameModificato = True;
    }

    if ($FileNameModificato) {
        #TRUE THEN filename = $finalNameFileModify
        $fileName = $FinalNameFileModify;
    } else {
        #FALSE THEN filename = filename
        $fileName = $file['name'];
    }
    # $fileName contiene il nome del file!

    # PARTE UPLOAD
    # Variabile check
    $esito = "Successo";
    # Apertura directory di lavoro
    $folder = opendir($uploadDir . "/");
    # check che non sia già presente il file
    while ($f = readdir($folder)) {
        if (is_file($uploadDir . "/" . $f)) {
            # CONTROLLO SOLO I FILE
            if ($f == $fileName) {
                # Se trova una corrispondenza variabile check diventa Falsa
                $esito = "Errore";
            }
        }
    }
    # Fine lavoro check presenza file
    $folder = closedir($folder);
    #caricamneto nel fileSystem



    if($esito == "Successo") {
        # Check dimensione non sfori la dimensione disponibile
        $dimDisponibileFloat = DimensionsUser($user)[5]['y'];
        $dimDisponibileByte = $dimDisponibileFloat/(1024*1024);
        if($dimDisponibileByte+$file['size']< getMaxDimension()){
            # inserimento dati nel database
            # Assegnazione nome file
            $fileName = basename($fileName);
            $query = "
                INSERT INTO files (idfile,filename,extension,MIME,pathfile,idusername,creationdate,creationhour)
                VALUES (0, :filename, :extension, :mime,:pathfile,:idusername,:creationdate,:creationhour)
                ";

            $date = date('Y-m-d');
            $hour = date('H:m:s');
            $idutente = $_SESSION['db_user_id'];

            $db_path=$uploadDir . DIRECTORY_SEPARATOR . $fileName;

            $fileextension=explode(".",basename($fileName));
            $ext=end($fileextension);

            $check = $pdo->prepare($query);
            $check->bindParam(':filename', $fileName, PDO::PARAM_STR);
            $check->bindParam(':extension', $ext, PDO::PARAM_STR);
            $check->bindParam(':mime', $file["type"], PDO::PARAM_STR);
            $check->bindParam(':pathfile', $db_path, PDO::PARAM_STR);
            $check->bindParam(':idusername', $idutente, PDO::PARAM_STR);
            $check->bindParam(':creationdate', $date, PDO::PARAM_STR);
            $check->bindParam(':creationhour', $hour, PDO::PARAM_STR);
            if($check->execute()){
                #True
                # Inserimento Nel filySystem
                move_uploaded_file($file['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $fileName);
                $messaggio = "L'operazione di insertimento del file ".$fileName." è andata a buon fine";
                header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
            }else{
                #False
                $messaggio = "L'operazione di insertimento del file ".$fileName." è fallita";
                header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
            }
        }else{
            $messaggio = "L'operazione di insertimento del file ".$fileName." è fallita perchè non c'è lo spazio necessario";
            header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
        }


    }else{
        $messaggio = "L'operazione di insertimento del file ".$fileName." è fallita";
        header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
    }
}else{  // se errore ritorna subito nella pagina precedente
    $messaggio = "L'operazione di insertimento del file ".$file['name']." è fallita";
    header("Location: http://serverwebuni.ns0.it:580/dashboard.php?esitoOperazione=".$messaggio."&currentdir=".$uploadDir);
}
?>