<!DOCTYPE html>
<?php
	session_start();
?>

<html lang="en-US">
    <head>
        <title>Cloud</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="This page contains the user interface that allow users to upload and download file from our Cloud Storage">
        <link rel="stylesheet" href="./style/style.css">
    </head>
    <body>
		<?php
        	if (isset($_SESSION['session_id'])) {
				$session_user = $_SESSION['session_user'];

				//$path = "./Data/".$session_user;
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
			</div>
			<div id="gridContainer">
				<div class="gridDiv">
					<div id="folderContainer">
						<div class="folderRow">
						</div>
					</div>
				</div>
				<div class="gridDiv" id="gridDivright">
					<div class="internalGridright" id="dimensions">
						<div id="chartContainer" style=" width: 100%; height: 300px;"></div>
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
			}else{
				echo "Errore di Login";
			}
		?>
    </body>
</html>
