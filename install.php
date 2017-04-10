<?php
include("_mysql.php");
include("_settings.php");
include("_functions.php");
$script_name = 'Dynamische Signatur';
$set = $_GET['set'];

function in_replace($file, $search, $replace){
	$change = $search;
	$change .= "\n".$replace;
	chmod($file, 0777);
		$content = file_get_contents($file);
		$content = str_replace($search, $change, $content);
		if(strpos($content,$replace) !== false) { $f_stat = true; }
	file_put_contents($file, $content);
	chmod($file, 0644);
	$chmod = substr(sprintf("%o", fileperms($file)), -4);
	if($chmod == '0644' AND $f_stat == true){ $status = '<div class="alert alert-success text-center" role="alert"> <code>'.$file.'</code> <br />installiert</div>'; } else { $status = '<div class="alert alert-danger" role="alert"> <code>'.$file.'</code> <br />Fehler: Datei konnte nicht ge&auml;ndert werden!</div>'; }

return $status;
}
function check($datei){
	if (file_exists($datei)) {
		$status= '<div class="alert alert-success" role="alert">Datei <code>'.$datei.'</code> gefunden</div>';
	} else {
		$status= '<div class="alert alert-danger" role="alert">Datei <code>'.$datei.'</code> nicht gefunden</div>';
	}
	return $status;
}

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>oneClick Install</title>
    <link href="http://data.atworkz.de/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://data.atworkz.de/css/installer.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://data.atworkz.de/css/bootstrap-switch.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <form method="post" action="install.php" enctype="multipart/form-data">
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right" role="tablist">
            <li class="active"><a href="install.php?kontakt=1">Kontakt</a></li>
          </ul>
        </nav>
        <h3 class="text-muted"><?php echo $script_name; ?><small>v0.9</small></h3>
      </div>
	
<?php
echo $error;
if($_POST['kontakt']){
	
	$_POST['nachricht'] = str_replace('&','&amp;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('ß','&szlig;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('ü','&uuml;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('Ü','&Uuml;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('ä','&auml;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('Ä','&Auml;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('ö','&ouml;',$_POST['nachricht']);
	$_POST['nachricht'] = str_replace('Ö','&Ouml;',$_POST['nachricht']);
	$nachricht = nl2br($_POST['nachricht']);
	$betreff = $_POST['betreff'];
	$date=date("d.m.Y");
	$name = $_POST["name"];
	$mail = $_POST["mail153"];
	$empfaenger = "info@atworkz.de";

	 $emailbody = '<!--

	Hallo!

	Ihr System unterst&uuml;tzt keine HTML-M@ils.

	Sie erhielten folgende Nachricht:

	$message

	 --> 
	Es wurde am '.$date.' eine E-Mail aus dem oneClick Installer geschickt!<br />
	Es handelt sich um das: '.$script_name.'<br /><br />
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

	if(isset($_POST['name'])) {
	$send_email = "no-reply@atworkz.de";
		if(!($name&&$mail&&$betreff&&$nachricht)) {
		$btnid=' warning';
		$error = '<br /><br /><div class="alert alert-danger">Bitte f&uuml;llen sie alle Felder aus!</div>';
		}
		else {
			$header = "From:oneClick Kontakformular <$send_email>\n";
			$header .= "Reply-To: $mail\n";
			$header .= "Content-Type: text/html";
		mail( $empfaenger,
			  $betreff,
			  $emailbody,
			$header);
		$btnid=' success';
		$error = '<div class="alert alert-success"><!-- SUCCESS -->
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Abgesendet!</strong> Ihre E-Mail wurde an uns verschickt.
									</div>';
		}

	}
}
if($_GET['kontakt']){
	echo '<h1>Kontakt</h1>
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
//Installation
elseif($_GET['step']){
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

	if($_GET['step']==1){
		//Dateien suchen
		$datei = Array(
				'0' => 'admin/languages/de/admincenter.php',
				'1' => 'admin/languages/uk/admincenter.php',
				'2' => 'admin/languages/de/signatur.php',
				'3' => 'admin/languages/uk/signatur.php',
				'4' => 'admin/admincenter.php',
				'5' => 'admin/signatur.php',
				'6' => 'fonts/04B_08.ttf',
				'7' => 'fonts/arial.ttf',
				'8' => 'fonts/opensans.ttf',
				'9' => 'fonts/verdana.ttf',
				'10' => 'images/signatur/demo.jpg',
				'11' => 'languages/de/seo.php',
				'12' => 'languages/uk/seo.php',
				'13' => 'languages/de/signatur.php',
				'14' => 'languages/uk/signatur.php',
				'15' => 'src/seo.php',
				'16' => 'src/func/user.php',
				'17' => 'sig.php',
				'18' => 'signatur.php'
			);
			
		echo'
		<div class="row setup-content" id="step-1">
				<div class="col-md-12 well text-center">
					<h1>Systeminformationen werden gesammelt...</h1><hr>';
						for($i=0; $i < 19; $i++){	
							$status = check($datei[$i]);
								echo $status;
							if(strpos($status,'danger') == true) $stop_c = 1;
								$stop = $stop_c+$stop;	
							}
							if($stop == 0){
								echo '<a href="install.php?step=2&set=30" class="btn btn-lg btn-success btn-block" />Weiter</a>';
							} else {
								echo '<a href="install.php?step=1&set=10" class="btn btn-lg btn-danger btn-block" />Erneuert pr&uuml;fen</a>';
							}
		echo'			
				</div>
		</div>';
	}
	elseif($_GET['step']==2){
		$n=0;
		$zahl = 1;
		
		//Find&Replace		
			$file = 'admin/admincenter.php'; 
			$search= '<li><a href="admincenter.php?site=scrolltext"><?php echo $_language->module[\'scrolltext\']; ?></a></li>';
			$replace= '	<li><a href="admincenter.php?site=signatur"><?php echo $_language->module[\'signatue\']; ?></a></li>';
		if($_GET['set']==40) {
			$file = 'admin/languages/de/admincenter.php'; 
			$search= '\'settings\'=>\'Einstellungen\',';
			$replace= '	\'signatue\'=>\'Signaturen\',';
		} 
		if($_GET['set']==50) {
			$file = 'admin/languages/uk/admincenter.php'; 
			$search= '\'settings\'=>\'Settings\',';
			$replace= '	\'signatue\'=>\'Signatue\',';
		} 
		if($_GET['set']==60) {
			$file = 'languages/de/seo.php'; 
			$search= '\'shoutbox\'=>\'Shoutbox\',';
			$replace= '	\'signatur\'=>\'Signatur\',';
		} 
		if($_GET['set']==70) {
			$file = 'languages/uk/seo.php'; 
			$search= '\'shoutbox\'=>\'Shoutbox\',';
			$replace= '	\'signatur\'=>\'Signature\',';
		}
		
		echo'
		<div class="row setup-content" id="step-2">
				<div class="col-md-12 well text-center">
					<h1>Installation wird ausgef&uuml;hrt...</h1>';
		
		while($n < $zahl) {
			$status = in_replace($file, $search, $replace);
				echo $status;
			$n++;
			if(strpos($status,'danger') == false) {
				if($set == 80){ 
					$set = 'install.php?step=3&set=80';
					redirect($set,"",3); 
				}
				else {
					$set = $set+10;
					$set = 'install.php?step=2&set='.$set;
					redirect($set,"",0);
				}
			} 
			else { 
				echo 'Ein Fehler in der Datei '.$file.' ist aufgetreten - Bitte Manuelle Installation ausf&uuml;hren!'; 
			}
		} 
		echo'
				</div>
		</div>
		';
	}
	elseif($_GET['step']==3){
		echo'
		<div class="row setup-content" id="step-3">
				<div class="col-md-12 well text-center">
					<h1>Datenbank wird beschrieben...</h1>
				</div>
		</div>
		';
		
		if($_GET['set']==80) {
			mysql_query("DROP TABLE IF EXISTS `".PREFIX."signatur`");
			mysql_query("INSERT INTO `".PREFIX."modules` (`moduleID`, `filename`, `activated`, `access`) VALUES ('', 'signatur.php', 1, '-1')");
			
				$set = $set+10;
				$set = 'install.php?step=3&set='.$set;
				redirect($set,"",0);
		}
		if($_GET['set']==90) {
			mysql_query("CREATE TABLE IF NOT EXISTS `".PREFIX."signatur` (
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
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ");
				$set = $set+10;
				$set = 'install.php?finish=1';
				redirect($set,"",0);
		}
	}
}

elseif($_GET['finish']){
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
					<a href="http://install.atworkz.de/?success=sig" class="btn btn-lg btn-success btn-block" />Abschlie&szlig;en</a>
				</div>
				
		</div>
	';
} 

else {
//Check auto/manuel
	if($_POST['install'] == 'on'){
		echo '
			<div class="jumbotron text-center">
				<h1>oneClick Install</h1>
				<p class="lead">Vorbereitungen</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>';
		//check CHMOD777
			$chmod_install = substr(sprintf("%o", fileperms('install.php')), -4);
				if($chmod_install == '0777'){ 
					echo '<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> Die Datei <code>install.php</code> hat CHMOD 777 Rechte!</div>';
					redirect('install.php?step=1&set=10',"",2);
				} 
				else { 
					echo '<div class="alert alert-danger" role="alert"><i class="fa fa-times"></i> Die Datei <code>install.php</code> hat keine CHMOD 777 Rechte!</div>'; 
					redirect('install.php',"",5);
				}
			echo '</p>
			</div>';	
	}

	elseif(isset($_POST['start'])) {
		echo'Manuelle Installation';
	}

	else {
		echo '
		<div class="jumbotron text-center">
			<h1>oneClick Install</h1>
			<p class="lead">Willkommen in der automatischen Installation der <?php echo $script_name; ?></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>Modus:<br /><input type="radio" name="install" checked data-radio-all-off="true" data-on-text="Automatische Installation" data-off-text="Manuelle Installation" class="switch-radio2"></p>
			<p>&nbsp;</p>
			<p><input class="btn btn-lg btn-success btn-block" name="start" type="submit" value="Jetzt starten" /></p>
		</div>';
	}
}

?>
      <footer class="footer">
        <p>&copy; <a href="http://www.atworkz.de" target="_blank">atworkz.de</a></p>
      </footer>  

    </div> 

	<!-- Javascripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://data.atworkz.de/js/bootstrap.min.js"></script>
	<script src="http://data.atworkz.de/js/bootstrap-switch.min.js"></script>
    <script src="http://data.atworkz.de/js/installer.js"></script>
	</form>
  </body>
</html>