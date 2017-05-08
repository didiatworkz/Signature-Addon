<!--
							_         
   ____                    | |        
  / __ \__      _____  _ __| | __ ____
 / / _` \ \ /\ / / _ \| '__| |/ /|_  /
| | (_| |\ V  V / (_) | |  |   <  / / 
 \ \__,_| \_/\_/ \___/|_|  |_|\_\/___|
  \____/                              
          
		http://www.atworkz.de	
		   info@atworkz.de	
________________________________________
		Webspell autoInstaller 
	   Version 1.2 - MAY 2017
________________________________________
-->

<?php
# ------------------------------------------------------------------------
# Include Webspell Files
include("_mysql.php");
include("_settings.php");
include("_functions.php");
# ------------------------------------------------------------------------
# ------------------------------------------------------------------------

## Installer Options:
# ------------------------------------------------------------------------
define('INSTALLER_NAME', 				'Dynamische Signatur'		);
define('INSTALLER_VERSION', 			'1.1'						);
define('INSTALLER_CONTACT_MAIL', 		'info@atworkz.de'			);
define('INSTALLER_COPYRIGHT_TEXT', 		'@atworkz'					);
define('INSTALLER_COPYRIGHT_LINK', 		'http://www.atworkz.de'		);
define('INSTALLER_COPYRIGHT_YEAR', 		'2017'						);

## Find Installation Files:
# Example: $find_file[] = 'admin/languages/de/admincenter.php';
# ------------------------------------------------------------------------
$find_file[] = 'admin/languages/de/admincenter.php';
$find_file[] = 'admin/languages/uk/admincenter.php';
$find_file[] = 'admin/languages/de/signature.php';
$find_file[] = 'admin/languages/uk/signature.php';
$find_file[] = 'admin/admincenter.php';
$find_file[] = 'admin/signature.php';
$find_file[] = 'fonts/04B_08.ttf';
$find_file[] = 'fonts/arial.ttf';
$find_file[] = 'fonts/opensans.ttf';
$find_file[] = 'fonts/verdana.ttf';
$find_file[] = 'images/signature/demo.jpg';
$find_file[] = 'languages/de/seo.php';
$find_file[] = 'languages/uk/seo.php';
$find_file[] = 'languages/de/signature.php';
$find_file[] = 'languages/uk/signature.php';
$find_file[] = 'src/seo.php';
$find_file[] = 'src/func/user.php';
$find_file[] = 'templates/logged.html';
$find_file[] = 'sig.php';
$find_file[] = 'signature.php';

## Change Filecontent
# Example: $files[] = 
#				array('filename' => 'admin/languages/de/admincenter.php', 
#					  'find'   =>   '\'settings\'=>\'Einstellungen\',', 
#              		  'add'  => 	  '	\'addonname\'=>\'Addonname\',');
# ------------------------------------------------------------------------
$files[] = 
		array('filename' => 'admin/admincenter.php', 
              'find'   => 	'<li><a href="admincenter.php?site=scrolltext"><?php echo $_language->module[\'scrolltext\']; ?></a></li>', 
              'add'  => 	'	<li><a href="admincenter.php?site=signature"><?php echo $_language->module[\'signature\']; ?></a></li>');
$files[] = 
		array('filename' => 'admin/languages/de/admincenter.php', 
              'find'   => 	'\'settings\'=>\'Einstellungen\',', 
              'add'  => 	'	\'signature\'=>\'Signaturen\',');
$files[] = 
		array('filename' => 'admin/languages/uk/admincenter.php', 
              'find'   => 	'\'settings\'=>\'Settings\',', 
              'add'  => 	'	\'signature\'=>\'Signature\',');
$files[] = 
		array('filename' => 'languages/de/seo.php', 
              'find'   => 	'\'shoutbox\'=>\'Shoutbox\',', 
              'add'  => 	'	\'signature\'=>\'Signatur\',');
$files[] = 
		array('filename' => 'languages/de/login.php', 
              'find'   => 	'\'registered_users\'=>\'registrierte Benutzer\',', 
              'add'  => 	'	\'signature\'=>\'Signatur\',');
$files[] = 
		array('filename' => 'languages/uk/seo.php', 
              'find'   => 	'\'shoutbox\'=>\'Shoutbox\',', 
              'add'  => 	'	\'signature\'=>\'Signature\',');
$files[] = 
		array('filename' => 'languages/uk/seo.php', 
              'find'   => 	'\'registered_users\'=>\'registered users\',', 
              'add'  => 	'	\'signature\'=>\'Signature\',');
$files[] = 
		array('filename' => 'templates/logged.html', 
              'find'   => 	'$cashbox', 
              'add'  => 	'&#8226; <a href="index.php?site=signature">%signature%</a><br />');


## MySQL Entries
# Example: $mysql[] = "INSERT INTO `".PREFIX."table` (`row1`, `row2`, `ro3`, `row4`) VALUES ('', 'value2', 3, 'value4')";
# ------------------------------------------------------------------------
$mysql[] = "DROP TABLE IF EXISTS `".PREFIX."signature`";
$mysql[] = "INSERT INTO `".PREFIX."modules` (`moduleID`, `filename`, `activated`, `access`) VALUES ('', 'signatur.php', 1, '-1')";
$mysql[] = "CREATE TABLE IF NOT EXISTS `".PREFIX."signature` (
			  `sigID` int(11) NOT NULL AUTO_INCREMENT,
			  `active` int(11) NOT NULL,
			  `color` varchar(255) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  `font` varchar(255) NOT NULL,
			  `size` varchar(255) NOT NULL,
			  `avatar` varchar(255) NOT NULL,
			  `avatar_X` varchar(255) NOT NULL,
			  `avatar_Y` varchar(255) NOT NULL,
			  `username` varchar(255) NOT NULL,
			  `username_X` varchar(255) NOT NULL,
			  `username_Y` varchar(255) NOT NULL,
			  `rang` varchar(255) NOT NULL,
			  `rang_X` varchar(255) NOT NULL,
			  `rang_Y` varchar(255) NOT NULL,
			  `town` varchar(255) NOT NULL,
			  `town_X` varchar(255) NOT NULL,
			  `town_Y` varchar(255) NOT NULL,
			  `web` varchar(255) NOT NULL,
			  `web_X` varchar(255) NOT NULL,
			  `web_Y` varchar(255) NOT NULL,
			  `text` varchar(255) NOT NULL,
			  `text_field` varchar(255) NOT NULL,
			  `text_X` varchar(255) NOT NULL,
			  `text_Y` varchar(255) NOT NULL,
			  PRIMARY KEY (`sigID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";			  
			  
			  
# ------------------------------------------------------------------------
# ------------------------------------------------------------------------
# ####    DO NOT EDIT ABOVE THIS LINE    ####
# ------------------------------------------------------------------------
# ------------------------------------------------------------------------
echo'<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.INSTALLER_NAME.' v'.INSTALLER_VERSION.' - autoInstaller</title>
    <link href="//data.atworkz.de/css/bootstrap.min.css" rel="stylesheet">
    <link href="//data.atworkz.de/css/installer.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
  <form method="post" action="install.php" enctype="multipart/form-data">
<div class="container" id="installer">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right" role="tablist">
            ';
			if(INSTALLER_CONTACT_MAIL != '') echo '<li class="active"><a href="install.php?kontakt=1">Kontakt</a></li>';
			echo'
          </ul>
        </nav>
        <h3 class="text-muted">'.INSTALLER_NAME.' <small>Version: '.INSTALLER_VERSION.'</small></h3>
      </div>

';
$set = (isset($_GET['set']) ? $_GET['set'] : null);

# Status function
function status($f_status, $f_file, $f_text) {
	echo '<div class="alert alert-'.$f_status.' text-center" role="alert"> <code>'.$f_file.'</code> <br />'.$f_text.'</div>';
}
# gohref function
function gohref($url, $time=1) {
	echo'<meta http-equiv="refresh" content="'.$time.';URL='.$url.'" />';
}
# Replace function
function in_replace($file, $search, $replace) {
	if(isset($file) != NULL) {
		$change = $search;
		$change .= "\n".$replace;
		chmod($file, 0777);
		$content = file_get_contents($file);
		$content = str_replace($search, $change, $content);
		if(strpos($content,$replace) !== false) {
			$f_stat = true;
		}
		file_put_contents($file, $content);
		chmod($file, 0644);
		$chmod = substr(sprintf("%o", fileperms($file)), -4);
		if($chmod == '0644' AND $f_stat == true) {
			$status = status("success", $file, "aktualisiert");
		}
		else {
			$status = status("danger", $file, "Fehler: Datei konnte nicht ge&auml;ndert werden!");
		}
		return $status;
	}
	else {
		$status = '<div class="alert alert-success text-center" role="alert">&nbsp; <br />&nbsp;</div>';
		return $status;
	}
}

# Filecheck function
function check($datei) {
	if (file_exists($datei)) {
		return 0;
	}
	else {
		return 1;
	}
}

# Mail function
if(isset($_POST['kontakt']) ? $_POST['kontakt'] : null) {
	$nachricht = nl2br($_POST['nachricht']);
	$betreff = $_POST['betreff'];
	$date=date("d.m.Y");
	$name = $_POST["name"];
	$mail = $_POST["mail153"];
	$empfaenger = INSTALLER_CONTACT_MAIL;
	$emailbody = '
	Es wurde am '.$date.' eine E-Mail aus dem autoInstaller geschickt!<br />
	Es handelt sich um die Installation von: <b>'.INSTALLER_NAME.' Version: '.INSTALLER_VERSION.'</b><br /><br />
	<br />Nachricht mit dem Betreff: <b>'.$betreff.'</b>
	<br />
	<br />
	<b>'.$name.'</b> schrieb:<br /><br />
	'.$nachricht.'
	<br /><br />
	----------------------------------<br />
	weitere Daten
	<br /><br />
	<b>Name:</b> '.$name.' <br />
	<b>E-Mail:</b> <a href="mailto:'.$mail.'">'.$mail.'</a>
	<br /><br />';
	$emailbody=stripslashes($emailbody);
	$send_mail = "no-reply@autoInstaller.de";
	# Send Mail
		if(!($name && $mail && $betreff && $nachricht)) {
			$error = '<br /><br /><div class="alert alert-danger">Bitte f&uuml;llen sie alle Felder aus!</div>';
		}
		else {
			$header = 'Content-type: text/html; charset=utf-8'."\r\n".
				'From: autoInstaller <no-reply@autoInstaller.de>'."\r\n" .
				'Reply-To: '.$mail."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			mail($empfaenger, $betreff, $emailbody, $header);
			$error = '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Abgesendet!</strong> Ihre E-Mail wurde an uns verschickt.
					  </div>';
		}
}

# Show Errorcode
if(isset($error)) echo $error;

# Contact Site
if(isset($_GET['kontakt']) ? $_GET['kontakt'] : null){
	echo '
	<h1>Kontakt</h1>
			<form action="install.php" method="post">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Name *</label>
											<input required type="text" maxlength="100" class="form-control" name="name" id="name">
										</div>
										<div class="col-md-6">
											<label>E-Mail Addresse</label>
											<input required type="email" data-msg-email="Bitte geben Sie eine g&uuml;ltige Adresse ein." maxlength="100" class="form-control" name="mail153" id="mail">
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Betreff</label>
											<input required type="text" maxlength="100" class="form-control" name="betreff" id="betreff">
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Nachricht *</label>
											<textarea required maxlength="5000" rows="10" class="form-control" name="nachricht" id="message"></textarea>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12 text-right">
									<a href="install.php" class="btn btn-danger" />abbrechen</a>
										<input type="submit" name="kontakt" value="absenden" class="btn btn-primary" data-loading-text="Loading...">
									</div>
								</div>
							</form>
		 <br /><br /><br />';
}

# Installation Site
elseif(isset($_GET['step']) ? $_GET['step'] : null) {
		echo'
		<div class="row form-group">
			<div class="col-xs-12">
				<ul class="nav nav-pills nav-justified thumbnail setup-panel">
					<li class="'; if($_GET['step']==1){ echo'active'; }else{ echo'disabled'; }; echo'"><a href="#step-1">
						<h4 class="list-group-item-heading">Schritt 1</h4>
						<p class="list-group-item-text">System pr&uuml;fen</p>
					</a></li>
					<li class="'; if($_GET['step']==2){ echo'active'; }else{ echo'disabled'; }; echo'"><a href="#step-2">
						<h4 class="list-group-item-heading">Schritt 2</h4>
						<p class="list-group-item-text">Datei Installation</p>
					</a></li>
					<li class="'; if($_GET['step']==3){ echo'active'; }else{ echo'disabled'; }; echo'"><a href="#step-3">
						<h4 class="list-group-item-heading">Step 3</h4>
						<p class="list-group-item-text">MySQL Installation</p>
					</a></li>
				</ul>
			</div>
		</div>';

		echo'
		<div class="progress">
		  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$set.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$set.'%">
			<span class="sr-only">'.$set.'% abgeschlossen</span>
		  </div>
		</div>	';

	# Step 1 -- check if File Exists
	if($_GET['step']==1) {
		$checkcount = 0;
		echo'
		<div class="row setup-content" id="step-1">
				<div class="col-md-12 well text-center">
					<h2>Informationen werden gesammelt...</h2><hr />';

						$file_max = count($find_file);
						for($i=0; $i<$file_max; $i++) {
							$status = check($find_file[$i]);
							if($status == 0) {
								$show_status=status("success", $find_file[$i], "Datei wurde gefunden");
							}
							else {
							$show_status=status("danger", $find_file[$i], "<strong>Datei wurde nicht gefunden!</strong>");
							$checkcount++;
							}
							echo $show_status;
						}
							if($checkcount == 0) {
								echo '<a href="install.php?step=2&set=50" class="btn btn-lg btn-success btn-block" />Weiter</a>';
							}
							else {
								echo '<a href="install.php?step=1&set=10" class="btn btn-lg btn-danger btn-block" />Erneuert pr&uuml;fen</a>';
							}
		echo'
				</div>
		</div>';
	}
	# Step 2 -- Change Files
	elseif($_GET['step']==2){
		$n=0;
		$arr_max = count($files);
		
		if($_GET['pro'] > 0) {
				$i = $_GET['pro'];
		}
		else {
				$i = 0;
		}
		
		if($i >= $arr_max/2){
			$set=80;
		}
		else {
			$set=50;
		}
		
		$percent = intval($i/$arr_max * 100);
		//Find&Replace


		echo'
		<div class="row setup-content" id="step-2">
				<div class="col-md-12 well text-center">
					<h2>Installation wird ausgef&uuml;hrt...</h2>
					<hr>
					';
						
			echo '<h3>Dateien werden verarbeitet</h3>
			<div class="progress">
		  <div class="progress-bar progress-bar-warning progress-bar-striped  active" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%">
			<span class="sr-only">'.$percent.'% abgeschlossen</span>
		  </div>
		</div>';			
						
	
		if($i < $arr_max){
			// Calculate the percentation
			$file =  $files[$i]['filename'];
			$search =  $files[$i]['find'];
			$replace =  $files[$i]['add'];
			$status = in_replace($file, $search, $replace);
			
			
			
			// Javascript for updating the progress bar and information
			
		$i++;
		$pro = 'install.php?step=2&set='.$set.'&pro='.$i;
		gohref($pro,0);
		}
		else {
		$set = 'install.php?step=3&set=90';
					gohref($set,3);
		}
		echo'
				</div>
		</div>
		';
	}
	# Step 3 -- Write Database
	elseif($_GET['step']==3){
		echo'
		<div class="row setup-content" id="step-3">
				<div class="col-md-12 well text-center">
					<h1>Datenbank wird beschrieben...</h1>
				</div>
		</div>
		';

		if($_GET['set']==90) {
			$sql_max = count($mysql);
			for($m=0; $m < $sql_max; $m++){
			$eintrag = $mysql[$m];
			mysql_query($eintrag);
			}
				$set = $set+10;
				$set = 'install.php?finish=1';
				gohref($set,1);
		}
	}
}

# Final Step
elseif(isset($_GET['finish']) ? $_GET['finish'] : null){
	echo'
		<div class="row">
				<div class="col-md-12 well text-center">
					<h1>Installation abgeschlossen</h1>
					<div class="progress">
						<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							<span class="sr-only">100% abgeschlossen</span>
						</div>
					</div>
					<hr>
					<a href="install.php?remove=1" class="btn btn-lg btn-success btn-block" />Abschlie&szlig;en</a>
				</div>

		</div>
	';
}
# Remove install.php
elseif(isset($_GET['remove']) ? $_GET['remove'] : null) {
	@unlink("install.php");
	gohref("index.php",0);
}

else {
//Check auto/manuel
	if((isset($_POST['install']) ? $_POST['install'] : null) == '1'){
		echo '
			<div class="well text-center">
				<h1>autoInstaller</h1>
				<p class="lead">Vorbereitungen</p>
				<p>&nbsp;</p>';
		//check CHMOD777
			chmod("install.php", 0777);
			$chmod_install = substr(sprintf("%o", fileperms('install.php')), -4);
				if($chmod_install == '0777'){
					echo '<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> Die Datei <code>install.php</code> hat CHMOD 777 Rechte!</div>';
					gohref('install.php?step=1&set=10',2);
				}
				else {
					echo '<div class="alert alert-danger" role="alert"><i class="fa fa-times"></i> Die Datei <code>install.php</code> hat keine CHMOD 777 Rechte!</div>';
					gohref('install.php',5);
				}
			echo '
			</div>';
	}

	# Installation
	elseif(isset($_POST['start'])) {
		echo'
		<br />
		<div class="pull-right"><a href="install.php?remove=1" class="btn btn-warning" />install.php löschen</a></div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#files" aria-controls="files" role="tab" data-toggle="tab">Dateien</a></li>
			<li role="presentation"><a href="#sql" aria-controls="sql" role="tab" data-toggle="tab">Datenbank</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="files">
			<div class="col-md-12">
			<span class="text-center"><h3>Folgende Dateien müssen bearbeitet werden:</h3></span><hr>
			<table class="table table-striped">
				<tr>
					<th>Datei</th>
					<th>Empfohlene Stelle <small>darunter einfügen</small></th>
					<th>Code</th>
				</tr>

			';
			$arr_max = count($files);
			for($i=0; $i < $arr_max; $i++){
			$file =  $files[$i]['filename'];
			$search =  $files[$i]['find'];
			$replace =  $files[$i]['add'];
				if(mb_strlen($search)> 40) {
				$search=mb_substr($search, 0, 40);
				$search.='...';
				}
			echo '
			  <tr>
				<td>'.$file.'</td>
				<td><code>'.htmlspecialchars($search).'<code></td>
				<td><input class="form-control" value="'.htmlspecialchars($replace).'" onclick="this.focus();this.select()" /></td>
			  </tr>
			';
			}
			echo'
			</table>
			</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="sql">
			<div class="col-md-12">
			<span class="text-center"><h3>Bitte in die Datenbank einspielen:</h3></span><hr>
			<div class="form-group">
			  <label for="mysql">MySQL Code:</label>
			  <textarea class="form-control" rows="20" onclick="this.focus();this.select()" id="mysql">
			';
			$sql_max = count($mysql);
			
			for($m=0; $m < $sql_max; $m++){
			$eintrag = $mysql[$m];
			echo htmlspecialchars($eintrag);
			echo '
			';
			}
			
			echo'
			 </textarea>
			</div>
			</div>
			</div>
		  </div>
		';
	}

	else {
		echo '
		<div class="well text-center">
			<h1>autoInstaller</h1>
			<p class="lead">Willkommen im autoInstaller für Webspell</p>
			<p>&nbsp;</p>
			<p>Modus:</p>
			<div class="btn-group" data-toggle="buttons">
			
			<label class="btn btn-success active">
				<input type="radio" name="install" value="1" id="option2" autocomplete="off" checked>
				Automatische Installation
			</label>

			<label class="btn btn-info">
				<input type="radio" name="install" value="0" id="option1" autocomplete="off">
				Manuelle Installation
			</label>
		
		</div>
			
			<p>&nbsp;</p>
			<p><input class="btn btn-lg btn-success btn-block" name="start" type="submit" value="Jetzt starten" /></p>
		</div>';
	}
}

echo '
 </div>
      <footer class="footer navbar-fixed-bottom">
	  <div class="col-md-6 text-left">';
	  if(INSTALLER_COPYRIGHT_TEXT != ''){
	  echo '<p>&copy; '.INSTALLER_COPYRIGHT_YEAR.' '.INSTALLER_NAME.' by';
		if(INSTALLER_COPYRIGHT_LINK != '') {
			echo ' <a href="'.INSTALLER_COPYRIGHT_LINK.'" target="_blank">'.INSTALLER_COPYRIGHT_TEXT.'</a></p>';
		}
		else {
			echo ' '.INSTALLER_COPYRIGHT_TEXT.'</p>';
		}
	  }
	  echo '
	  </div>
	  
	  <div class="col-md-6 text-right">
	  <p>&copy; '.date('Y').' autoInstaller by <a href="http://www.atworkz.de" target="_blank">@atworkz</a></p>
	  </div>
      </footer>

	<!-- Javascripts -->
    <script src="http://data.atworkz.de/js/jquery.min.js"></script>
    <script src="http://data.atworkz.de/js/bootstrap.min.js"></script>
    <script src="http://data.atworkz.de/js/installer.js"></script>
	</form>
  </body>
</html>
';
?>