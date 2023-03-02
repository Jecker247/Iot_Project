<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $command = $_GET['command'];
                // Path & Id temporaneo:                # AUTOMATIZZARE PROCEDIMENTO
                $id = 1;
                $path = "/var/www/html/Data/LucaDaniel";
                switch ($command) {
                    case 'CD':  #cambio directory 
                        # code...
                        break;
                    case 'UF':  #inserisco un file
                        $file = $_FILES["file"];
                        if(UPLOAD_ERR_OK == $file["error"]) { # check upload isset($_FILES['file'])
                            #$dimDisponibileFloat = DimensionsUser($id)[5]['y'];   #need trovare ID del user se non usiamo le sessioni
                            #$dimDisponibileByte = $dimDisponibileFloat/(1024*1024);
                            #if($dimDisponibileByte+$file['size']< getMaxDimension()){ #controllo spazio disponibile
                             #check nome file conforme:
                             #variabile per troncamento:
                             $MaxCaratteri = 22;
                             if (strlen($file['name']) > $MaxCaratteri) {
                                 #TRUE then modifica filename = nome troncato a 22+ext
                                 $FileNameModify = $file['name'];
                                 #explode per ottenere la parte finale (estensione)
                                 $fileNameParts = explode('.', $FileNameModify);
                                 $ext = end($fileNameParts);
                                 #ottengo substring
                                 $fileSubstringModify = substr($FileNameModify, 0, $MaxCaratteri);
                                 #concateno Stringa File Name Modificata
                                 $FinalNameFileModify = $fileSubstringModify . "." . $ext;
                                 #$FinalNameFileModify variabile con stringa finale!
                                 $fileName = $FinalNameFileModify;
                             }else{
                                 #FALSE THEN filename = filename
                                 $fileName = $file['name'];
                             }
                             #check file non sia uguale ad uno esistente nel path working dir
                            $workingDir = $path."/".$fileName;
                             if(fopen($workingDir, "r")){
                                #Non Puoi inserire il file
                                 echo "Ciao sono nel caso che il file e' gia presente nella working directory";
                             }else{
                                 #Puoi inserire il file
                                 #caricamento nel FileSystem:
                                 #fileName gia' ottenuto sopra con possibile casting se necessario
                                 $fileTmpName = $_FILES['file']['tmp_name'];
                                 //move_uploaded_file($fileTmpName, $path."/".$fileName);   #da abilitare quanto tutto e' sistemato
                                 // creazione file JSON
                                 # Informazioni necessarie: FileName - Path - IdUser
                                 $Informazione = array($fileName,$path, $id);
                                 // codifica JSON
                                 $FileJson = json_encode($Informazione);
                                 #delegazione alla pagina UPLOAD.
                                // header("Location: ./upload.php?Json=".$FileJson);
                                 echo "Ciao sono nel caso corretto";
                             }
                            #}else{ #if controllo spazione disponibile
                                #echo "Ciao sono nel caso dove non c'e enough spazio";
                            #}
                        }else{
                            #file non caricato correttamente
                            echo "Ciao sono nel caso che il file non e' stato caricato correttamente";
                        }
                        break;
                    case 'DF':  #estraggo un file
                        # code...
                        break;    
                    case 'MKDIR':   #creo una nuova cartella
                        # delego il lavoro impostando come paramentri path + nome cartella
                        $nameFolder=$_POST['nameFolder'];
                        //header("Location: ./createFolder.php?path=".$path."&nameFolder=".$nameFolder);  # da abilitare in fase di testing
                        break;    
                    case 'RMDIR':   #rimuovo una cartella solo se è vuota 
                        # code...
                        break; 
                    case 'RF':     #rimuove un file
                        # code...
                        break; 
                    case 'MFDIR':   #modifica il nome di una cartella 
                        # code...
                        break; 
                    default:        # comando non trovato, gestione dell'errore...
                        # code...
                        break;
                }
            } else {
                http_response_code(405); // Metodo non consentito
                echo "Metodo non consentito";
            }
        ?>
    </body>
</html>