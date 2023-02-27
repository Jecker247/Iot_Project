<!DOCTYPE html>
<?php
include("./config/dimensions.php");
session_start();
if(isset($_SESSION['session_id'])){
    $session_user = $_SESSION['session_user'];
    $data = DimensionsUser($session_user);
}
?>

<html lang="en-US">
<head>
    <title>Cloud</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This page contains the user interface that allow users to upload and download file from our Cloud Storage">
    <link rel="stylesheet" href="./style/style.css">
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                backgroundColor: "#F9F9FF",
                theme: "light1",
                title:{
                    text: "Space Usage's Diagram ( 500 MB )"
                },
                data: [{
                    type: "pie",
                    explodeOnClick: true,
                    startAngle:  -45,
                    indexLabelFontSize: 15,
                    indexLabel: "{label} - #percent%",
                    yValueFormatString: "###.##### MB",
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>
<body>
<?php
if (isset($_SESSION['session_id'])) {
    # Elaborazione path corrente working directory
    $RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
    if (isset($_SESSION['LastRequest'])&&($_SESSION['LastRequest'] == $RequestSignature)){
        # gestione F5 refresh della pagina:
        $_SESSION['PercorsoAttuale']=$_SESSION['PercorsoAttuale'];
    }else{
        $_SESSION['LastRequest'] = $RequestSignature;
        # gestione File System ricorsione:
        if(isset($_GET['folder'])){
            $_SESSION['PercorsoAttuale'] = $_SESSION['PercorsoAttuale']."/".$_GET['folder'];
        }else if(isset($_GET['currentdir'])){
            $_SESSION['PercorsoAttuale'] = $_GET['currentdir'];
        } //testing
        else if(isset($_GET['directory'])){
            $_SESSION['PercorsoAttuale'] =$_GET['directory'];
        }else {
            $_SESSION['PercorsoAttuale'] = __DIR__."/Data/".$session_user;  //."/"
        }
    }
    ?>
    <div class="header">
        <div class="inner-header">
        </div>
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </div>
    </div>
    <div class="containerDash">
        <div>
            <div id="headerDash">
                <img src="./img/icon.png" width="100px" height="100px">
                <h2>Welcome, <?php echo $session_user; ?> </h2>
            </div>
            <button id="FileQuestionButton" class='mainButtonClass' title="I nomi troppo lunghi dei file vengono accorciati per motivi tecnici!"></button>
            <button id="HelperButton" class='mainButtonClass' title="Se trovi bug o hai bisogno di aiuto contatta: CloudHelper@gmail.com"></button>
            <button id="logoutButton" onclick="window.location.href='./php/logout.php';">logout</button>
            <hr>
            <div id="GUIRicerca">

                <?php
                # Gestione bottoni navigazione sito e visualizzazione working directory:
                if($_SESSION['PercorsoAttuale'] == __DIR__."/Data/".$session_user){
                    # Caso HOME  | Tutti i bottoni disabilitati
                    echo "<button id='BackButton' class='mainButtonClass' disabled></button>";
                    echo "<button id='HomeButton' class='mainButtonClass' onclick='location.href='http://serverwebuni.ns0.it:580/dashboard.php'' disabled></button>";
                    # Showing empty directory  | attualmente in /var/www/html/Data/ CurrentUsername
                    echo "<input id=\"dirPath\" type=\"text\" value=\"/\" disabled>";
                }else{
                    # Caso Folder e ricorsione  | Bottoni abilitati
                    echo "<button id='BackButton' class='mainButtonClass' style='height:40px; width:40px;position:relative;top:12px;' onclick='location.href=\"../back.php\"'></button>";
                    echo "<button id='HomeButton' class='mainButtonClass' style='height:40px; width:40px;position:relative;top:12px; margin-left:5px;margin-right:8px;' onclick='location.href=\"http://serverwebuni.ns0.it:580/dashboard.php\"'></button>";
                    // current folder elaboration & visualization:
                    if(isset($_GET['currentdir'])) {
                        $nomeFolderAttuale = $_GET['currentdir'];
                        $nomeFolder = explode('/', $nomeFolderAttuale);
                        $nF = end($nomeFolder);
                    }else if(isset($_POST['directory'])){
                        $nomeFolderAttuale = $_POST['directory'];
                        $nomeFolder = explode('/', $nomeFolderAttuale);
                        $nF = end($nomeFolder);
                    }else if(isset($_GET['directory'])){
                        $nomeFolderAttuale = $_GET['directory'];
                        $nomeFolder = explode('/', $nomeFolderAttuale);
                        $nF = end($nomeFolder);
                    }else{
                        $nF = $_GET['folder'];
                    }
                    $vector = explode("/",$_SESSION["PercorsoAttuale"]);
                    echo "<input id=\"dirPath\" type=\"text\" value=\""."/".implode("/", array_slice($vector, 6, sizeof($vector)))."\" disabled>";
                }
                ?>
            </div>

        </div>
        <div id="gridContainer">
            <div id="FileContainer" class="gridDiv">
                <?php
                # Zona lavoro: left grid | Show Folders and Files
                # Ottenimento working directory
                $folder = opendir($_SESSION['PercorsoAttuale']."/");
                # lettura file and folder presenti nella Dir e visualizzazione:
                while ($f = readdir($folder)) {
                    if (is_file($_SESSION['PercorsoAttuale']."/" . $f)) {
                        $fileName = $f;
                        $fileNameParts = explode('.', $fileName);
                        $ext = end($fileNameParts);
                        #CONTROLLO SOLO I FILE
                        echo "<div style='margin:5px'>";
                        echo "<img src=\"./img/".IconSelector($ext)."\" style='width:100px;height:100px;'>";
                        echo "<figcaption style='text-align: justify;width:110px;height:70px;word-break: break-all;' >".$f."</figcaption>";
                        echo "</div>";
                    }
                    if(is_dir($_SESSION['PercorsoAttuale']."/" . $f)){
                        #CONTROLLO SOLO LE CARTELLE
                        if($f != "." and $f != ".."){
                            #RAPPRESENTAZIONE CARTELLE
                            echo "<div style='margin:5px'>";
                            echo "<a href=\"..\dashboard.php?folder=".$f."\" style='text-decoration: inherit;color:black'>";
                            echo "<img src='./img/Folder_Icon.png' style='width:100px;height:100px;'>";
                            echo "<figcaption style='text-align: justify;word-break: break-all;width:110px;height:50px;'>".$f."</figcaption>";
                            echo "</a>";
                            echo "</div>";
                        }
                    }
                }
                # chiusura della cartella attuale finita la lettura:
                $folder = closedir($folder);
                ?>
            </div>
            <div class="gridDiv" id="gridDivright">
                <!--  Zona lavoro: top-right grid -->
                <!--  rappresentazione Grafico Space Usage -->
                <div class="internalGridright" id="dimensions">
                    <div id="chartContainer" style=" width: 100%; height: 300px;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </div>
                <div class="internalGridright" id="insertModel">

                    <div id="barraGridRight">
                        <!--  Zona lavoro: bottom-right grid | Form Operations-->
                        <form action="dashboard.php" method="GET">
                            <h3 id="TitoloForm">Select the operation to perform:</h3>
                            <div id="RadioGriglia">
                                <div>
                                    <input type="radio" id="UploadFile" name="OperazioneCloud" value="uploadFile" class='radioClass'></input>
                                    <label for="UploadFile" >UploadFile</label>
                                </div>
                                <div>
                                    <input type="radio" id="RemoveFile" name="OperazioneCloud" value="removeFile" class='radioClass'></input>
                                    <label for="RemoveFile">RemoveFile</label>
                                </div>
                                <div>
                                    <input type="radio" id="InsertFolder" name="OperazioneCloud" value="insertFolder" class='radioClass'></input>
                                    <label for="InsertFolder">InsertFolder</label>
                                </div>
                                <div>
                                    <input type="radio" id="ModifyFolder" name="OperazioneCloud" value="modifyFolder" class='radioClass'></input>
                                    <label for="ModifyFolder">ModifyFolder</label>
                                </div>
                                <div>
                                    <input type="radio" id="RemoveFolder" name="OperazioneCloud" value="removeFolder" class='radioClass'></input>
                                    <label for="RemoveFolder">RemoveFolder</label>
                                </div>
                                <div>
                                    <input type="radio" id="DownloadFile" name="OperazioneCloud" value="downloadFile" class='radioClass'></input>
                                    <label for="DownloadFile">DownloadFile</label>
                                </div>
                                <input type="radio" id="Directory" name="directory" value="<?php echo $_SESSION['PercorsoAttuale'];?>" class="invisibleField" checked ></input>

                            </div>
                            <!--  bottoni form -->
                            <div style="padding-bottom: 30px;">
                                <input type="submit" class="buttonsFormClass" value="Submit Operation" name="submit"/>
                                <input type="submit"  class="buttonsFormClass" value="Undo Operation" name="undo"/>
                            </div>
                        </form>
                        <?php
                        # Gestione bottoni form, case Undo & Submit
                        if(isset($_GET['undo'])){
                            # Case Undo: refresha solo la pagina togliendo il form di compilazione della operazione selezionata precedentemente
                            header("Location: http://serverwebuni.ns0.it:580/dashboard.php?currentdir=".$_SESSION['PercorsoAttuale']);
                        }else if(isset($_GET['submit'])){
                            # gestione form dopo esecuzione button submit operation | Showing the corret operation that we want to do
                            if(isset($_GET['OperazioneCloud'])){
                                $OperazioneCloud = $_GET['OperazioneCloud'];
                                if($OperazioneCloud  == "uploadFile"){
                                    ?>
                                    <form action="inserimentoFile.php" method="post" enctype="multipart/form-data">
                                        <label for="UploadFile" style="font-weight: bold;font-family: Trebuchet MS, Arial, Tahoma, Serif;">Insert file to upload:</label><br>
                                        <input type="file" name="file" style="height:30px; width:310px;padding-top: 10px;"></input>
                                        <input type="text" name="directory"  style="visibility:hidden; height:20px; width:0px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                        <input type="submit" value="Submit" style="height:20px; width:120px;border-radius: 16px;border: none;"></input>
                                    </form>
                                    <?php
                                }else  if($OperazioneCloud  == "removeFile"){
                                    ?>
                                    <form action="rimozioneFile.php" method="post">
                                        <label for="RemoveFile" style="font-weight: bold;font-family: Trebuchet MS, Arial, Tahoma, Serif;">Put name file to Remove:</label><br>
                                        <input type="text" name="nomeFile" placeholder="name file to remove" style="height:20px; width:150px;margin-top: 10px;"></input>
                                        <input type="text" name="directory" style="visibility:hidden;height:20px; width:150px;" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                        <input type="submit" value="Remove File"  style="height:20px; width:120px;border-radius: 16px;border: none;"></input>
                                    </form>
                                    <?php
                                }else if($OperazioneCloud  == "insertFolder"){
                                    ?>
                                    <form action="inserimentoFolder.php" method="post">
                                        <label for="InsertFolder" style="font-weight: bold;font-family: Trebuchet MS, Arial, Tahoma, Serif;">Put name folder to insert:</label><br>
                                        <input type="text" name="nomeFolder" placeholder="name folder to insert" style="height:20px; width:150px;margin-top: 10px;"></input>
                                        <input type="text" name="directory" style="visibility:hidden;height:20px; width:150px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                        <input type="submit" value="New Folder"  style="height:20px; width:120px;border-radius: 16px;border: none;"></input>
                                    </form>
                                    <?php
                                }else if($OperazioneCloud  == "modifyFolder"){
                                    ?>
                                    <form action="modificaFolder.php" method="post">
                                        <label for="ModifyFolder" style="font-weight: bold;font-family: Trebuchet MS, Arial, Tahoma, Serif;">Insert name folder to modify:</label><br>
                                        <input type="text" name="oldname" placeholder="name folder" style="height:20px; width:145px;margin-top: 10px;"></input>
                                        <input type="text" name="newname" placeholder="new name folder" style="height:20px; width:145px;margin-top: 10px;"/>
                                        <input type="text"  name="directory" style="visibility:hidden;height:20px; width:0px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                        <input type="submit" value="Modify Folder"  style="height:20px; width:120px;border-radius: 16px;border: none;"></input>
                                    </form>
                                    <?php
                                }else if($OperazioneCloud  == "removeFolder"){
                                    ?>
                                    <form action="rimozioneFolder.php" method="post">
                                        <label for="RemoveFolder" style="font-weight: bold;font-family: Trebuchet MS, Arial, Tahoma, Serif;">Put name folder to Remove:</label><br>
                                        <input type="text" name="rimFolder" placeholder="name folder to remove"  style="height:20px; width:150px;margin-top: 10px;"/>
                                        </input><input type="text" name="directory" style="visibility:hidden;height:20px; width:150px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                        <input type="submit" value="Remove Folder"  style="height:20px; width:120px;border-radius: 16px;border: none;"></input>
                                    </form>
                                    <?php
                                }else  if($OperazioneCloud  == "downloadFile"){
                                    ?>
                                    <form action="downloadFile.php" method="post">
                                        <label for="DownloadFile" style="font-weight: bold;font-family: Trebuchet MS, Arial, Tahoma, Serif;">Put file name to Download:</label><br>
                                        <input type="text" name ="downloadFileName" placeholder="name file to download"  style="height:20px; width:150px;margin-top: 10px;"></input>
                                        <input type="text" name="directory" style="visibility:hidden;height:20px; width:150px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                        <input type="submit" value="Download File"  style="height:20px; width:120px;border-radius: 16px;border: none;"></input>
                                    </form>

                                    <?php
                                }
                            }else{
                                # schiaccio due volte Submit senza aver selezionato l'operazione
                                # Avviso errore
                                $mex='Non hai selezionato nessuna operazione';
                                echo '<script type="text/javascript">alert("'.$mex.'");</script>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}else{
    echo "Errore di Login";
}
?>
<?php
# Showing Error or Completated operation:
if(isset($_GET["esitoOperazione"])){
    $risultato = $_GET["esitoOperazione"];
    echo '<script type="text/javascript">alert("'.$risultato.'");</script>';
}

?>
</body>
</html>
