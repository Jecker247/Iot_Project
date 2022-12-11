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
    // ricerca file e cartelle    SPOSTATO QUA SOPRA PER TESTING
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
            <button id="logoutButton" onclick="window.location.href='./php/logout.php';">logout</button>
            <hr>
            <div style="position: relative; left: 10px;">

                <?php
                    if($_SESSION['PercorsoAttuale'] == __DIR__."/Data/".$session_user){
                        echo "<button id='BackButton' class='mainButtonClass' disabled></button>";
                        echo "<button id='HomeButton' class='mainButtonClass' onclick='location.href='http://serverwebuni.ns0.it:580/dashboard.php'' disabled></button>";
                    }else{
                        echo "<button id='BackButton' class='mainButtonClass' onclick='location.href=\"../back.php\"'></button>";
                        echo "<button id='HomeButton' class='mainButtonClass' onclick='location.href=\"http://serverwebuni.ns0.it:580/dashboard.php\"'></button>";
                        // current folder visualization:
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
                        echo "Cartella Attuale: ".$nF;
                    }
                ?>
            </div>

        </div>
        <div id="gridContainer">
            <div class="gridDiv" style="display:grid; grid-template-columns: auto auto auto auto auto;overflow-y: scroll;">
                <?php

                $folder = opendir($_SESSION['PercorsoAttuale']."/");
                while ($f = readdir($folder)) {
                    if (is_file($_SESSION['PercorsoAttuale']."/" . $f)) {

                        $fileName = $f;
                        $fileNameParts = explode('.', $fileName);
                        $ext = end($fileNameParts);

                        #CONTROLLO SOLO I FILE
                        echo "<div style='margin:5px'>";
                        //echo "<a href=\"..\dashboard.php?file=\"\"\" style='text-decoration: inherit;color:black'>";
                        echo "<img src=\"./img/".IconSelector($ext)."\" style='width:100px;height:100px;'>";             // ='./img/File_Icon.png'
                        echo "<figcaption style='text-align: justify;width:110px;height:70px;word-break: break-all;' >".$f."</figcaption>";
                       // echo "</a>";
                        echo "</div>";
                    }
                    if(is_dir($_SESSION['PercorsoAttuale']."/" . $f)){
                        #CONTROLLO SOLO LE CARTELLE
                        if($f != "." and $f != ".."){
                            #RAPPRESENTAZIONE CARTELLE

                            echo "<div style='margin:5px'>";
                            echo "<a href=\"..\dashboard.php?folder=".$f."\" style='text-decoration: inherit;color:black'>";   #\"..\dashboard.php?folder=\"\"\"";
                            echo "<img src='./img/Folder_Icon.png' style='width:100px;height:100px;'>";
                            echo "<figcaption style='text-align: justify;word-break: break-all;width:110px;height:50px;'>".$f."</figcaption>";
                            echo "</a>";
                            echo "</div>";
                        }

                    }
                }

                $folder = closedir($folder);

                ?>

            </div>
            <div class="gridDiv" id="gridDivright">
                <div class="internalGridright" id="dimensions">
                    <div id="chartContainer" style=" width: 100%; height: 300px;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </div>
                <div class="internalGridright" id="insertModel">

                    <div id="barraGridRight">
                        <div id="testing" style="display:grid; vertical-align: baseline; padding: 10px;">
                            <form action="dashboard.php">
                                <p>seleziona l'operazione che vuoi eseguire:</p>
                                <div>
                                    <input type="radio" id="UploadFile" name="OperazioneCloud" value="uploadFile" style="width:1.15em; height: 1.15em"></input>
                                    <label for="UploadFile" >UploadFile</label>
                                </div>
                                <div>
                                    <input type="radio" id="RemoveFile" name="OperazioneCloud" value="removeFile" style="width:1.15em; height: 1.15em"></input>
                                    <label for="RemoveFile">RemoveFile</label>
                                </div>
                                <div>
                                    <input type="radio" id="InsertFolder" name="OperazioneCloud" value="insertFolder" style="width:1.15em; height: 1.15em"></input>
                                    <label for="InsertFolder">InsertFolder</label>
                                </div>
                                <div>
                                    <input type="radio" id="ModifyFolder" name="OperazioneCloud" value="modifyFolder" style="width:1.15em; height: 1.15em"></input>
                                    <label for="ModifyFolder">ModifyFolder</label>
                                </div>
                                <div>
                                    <input type="radio" id="RemoveFolder" name="OperazioneCloud" value="removeFolder" style="width:1.15em; height: 1.15em"></input>
                                    <label for="RemoveFolder">RemoveFolder</label>
                                </div>
                                <div>
                                    <input type="radio" id="DownloadFile" name="OperazioneCloud" value="downloadFile" style="width:1.15em; height: 1.15em"></input>
                                    <label for="DownloadFile">DownloadFile</label>
                                </div>
                                <input type="radio" id="Directory" name="directory" value="<?php echo $_SESSION['PercorsoAttuale'];?>" style="visibility: hidden;width:0px; height:0px " checked ></input>
                                <div style="padding-bottom: 15px;"><input type="submit" style="width:60px; height:20px " value="Submit"></div>
                            </form>
                        </div>

                        <?php
                        if(isset($_GET['OperazioneCloud'])){
                            $OperazioneCloud = $_GET['OperazioneCloud'];
                            if($OperazioneCloud  == "uploadFile"){
                                ?>
                                <form action="inserimentoFile.php" method="post" enctype="multipart/form-data">
                                    <label for="UploadFile" style="font-weight: bold;">Insert file to upload</label><br>
                                    <input type="file" name="file" style="height:30px; width:350px"></input>
                                    <input type="text" name="directory"  style="visibility:hidden; height:20px; width:0px" " value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                    <input type="submit" value="Submit" style="height:20px; width:120px"></input>
                                </form>
                                <?php
                            }else  if($OperazioneCloud  == "removeFile"){
                                ?>
                                <form action="rimozioneFile.php" method="post">
                                    <label for="RemoveFile" style="font-weight: bold;"  >Remove file</label><br>
                                    <input type="text" name="nomeFile" placeholder="name file to remove" style="height:20px; width:150px">
                                    </input><input type="text" name="directory" style="visibility:hidden;height:20px; width:191px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                    <input type="submit" value="Remove File"  style="height:20px; width:120px"></input>
                                </form>
                                <?php
                            }else if($OperazioneCloud  == "insertFolder"){
                                ?>
                                <form action="inserimentoFolder.php" method="post">
                                    <label for="InsertFolder" style="font-weight: bold;">Insert folder</label><br>
                                    <input type="text" name="nomeFolder" placeholder="name folder to insert" style="height:20px; width:157px">
                                    </input><input type="text" name="directory" style="visibility:hidden;height:20px; width:184px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                    <input type="submit" value="New Folder"  style="height:20px; width:120px"></input>
                                </form>
                                <?php
                            }else if($OperazioneCloud  == "modifyFolder"){
                                ?>
                                <form action="modificaFolder.php" method="post">
                                    <label for="ModifyFolder" style="font-weight: bold;">Modify folder</label><br>
                                    <input type="text" name="oldname" placeholder="name folder" style="height:20px; width:150px"></input>
                                    <input type="text" name="newname" placeholder="new name folder" style="height:20px; width:160px"/>
                                    <input type="text"  name="directory" style="visibility:hidden;height:20px; width:18px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                    <input type="submit" value="Modify Folder"  style="height:20px; width:120px"></input>
                                </form>
                                <?php
                            }else if($OperazioneCloud  == "removeFolder"){
                                ?>
                                <form action="rimozioneFolder.php" method="post">
                                    <label for="RemoveFolder" style="font-weight: bold;">Remove folder</label><br>
                                    <input type="text" name="rimFolder" placeholder="name folder to remove"  style="height:20px; width:157px">
                                    </input><input type="text" name="directory" style="visibility:hidden;height:20px; width:184px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                    <input type="submit" value="Remove Folder"  style="height:20px; width:120px"></input>
                                </form>
                                <?php
                            }else  if($OperazioneCloud  == "downloadFile"){
                                ?>
                                <form action="downloadFile.php" method="post">
                                    <label for="DownloadFile" style="font-weight: bold;">Download file</label><br>
                                    <input type="text" name ="downloadFileName" placeholder="name file to download"  style="height:20px; width:157px">
                                    </input><input type="text" name="directory" style="visibility:hidden;height:20px; width:184px" value="<?php echo $_SESSION['PercorsoAttuale'];?>"/>
                                    <input type="submit" value="Download File"  style="height:20px; width:120px"></input>
                                </form>

                                <?php
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
if(isset($_GET["operazione"])){
    $esito = $_GET["operazione"];
    if($esito=='Errore'){
        echo '<script>window.alert("Operazione non riuscita")</script>';
    }else{
        echo '<script>window.alert("Operazione eseguita con successo")</script>';
    }
}
?>
</body>
</html>

