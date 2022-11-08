<?php
	session_start();
	if (isset($_SESSION['session_id'])) {
		$session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
		//$data = DimensionsUser($session_user);
	}
?>
<html>
    <head>
        <title>Cloud</title>
        <link rel="stylesheet" href="./style/style.css">
		<!--<script>
			window.onload = function() {
				var chart = new CanvasJS.Chart("chartContainer", {
					theme: "light2",
					animationEnabled: false,
					backgroundColor: "#F9F9FF",
					title: {
						text: "Space Usage's Diagram"
					},
					data: [{
						type: "pie",
						indexLabel: "{label} ({y})",
						yValueFormatString: "#,##0.00\"%\"",
						indexLabelFontColor: "#36454F",
						
						indexLabelFontSize: 15,
						showInLegend: true,
						legendText: "{label}",
						dataPoints: <?php //echo json_encode($data, JSON_NUMERIC_CHECK); ?>
					}]
				});
				chart.render(); 
			}
		</script>-->
    </head>
    <body>
        <?php
        	if (isset($_SESSION['session_id'])) {
				if(!isset($_GET['path'])){
					$path = ".".DIRECTORY_SEPARATOR."Data".DIRECTORY_SEPARATOR.$session_user;
				}else{
					$path = $_GET['path'];
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
						<h2>Welcome, <?php echo $session_user; ?></h2>
					</div>
					<button id="logoutButton" onclick="window.location.href='./php/logout.php';">logout</button>
					<hr>
				</div>
				<div id="gridContainer">
					<div class="gridDiv">
						<div id="divToolBar">barra degli strumenti</div>
						<div id="folderContainer">
							<div class="folderRow">
							</div>
						</div>
					</div>
					<div class="gridDiv" id="gridDivright">
						<div class="internalGridright" id="dimensions">
							<div id="chartContainer" style=" width: 100%; height: 300px;"></div>
							<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
						</div>
						<div class="internalGridright" id="insertModel">
							<form>
								<label for="UploadFile">insert file to upload in Cloud</label>
								<input type="file"></input>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php	
        	} else {
            printf("Effettua il %s per accedere all'area riservata", '<a href="../login.html">login</a>');
        	}
        ?>
    </body>
</html>

