<?php
/*
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
	Signatur Addon for Webspell 4.x
	   Version 0.9 -- March 2015
________________________________________
*/
$_language->read_module('signatur', true);
$_language->get_installed_languages();
	
$_language_cat = new Language;
$_language_cat->set_language($_language->language);
$_language_cat->db_read_module('signatur');


echo '<h1>&curren; '.$_language->module['headline'].'</h1>';
echo '<br /><br /><br />';
	
if($_GET['choose']) {

	$code = 'http://'.$_SERVER['HTTP_HOST'].'/sig.php?id='.$userID.'&sig='.$_GET['choose'];

	echo '
	<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
	<tr>
		<td colspan="2" class="td1" align="center"><img style="max-width:550px" src="'.$code.'" /></td>
	</tr>
	<tr>
		<td class="td1" align="center"><b>'.$_language->module['code_text'].'</b></td>
		<td class="td1" align="center"><textarea onclick="this.focus();this.select()" cols="40" rows="3"><img src="'.$code.'" alt="'.$_language->module['signature'].'" /></textarea></td>
	</tr>
	<tr>
		<td colspan="2" class="td1" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=signatur\');return document.MM_returnValue" value="'.$_language->module['back'].'" />   <input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=signatur&amp;profile='.$_GET['choose'].'\');return document.MM_returnValue" value="'.$_language->module['bind_profil'].'" /></td>
	</tr>
	</table>
	<br /><br /><hr>';
	}
	
elseif($_GET['profile']) {
	$user = mysql_fetch_array(safe_query("SELECT usertext FROM ".PREFIX."user WHERE userID='".$userID."' LIMIT 1"));
	$code = 'http://'.$_SERVER['HTTP_HOST'].'/sig.php?id='.$userID.'&sig='.$_GET['profile'];
	$signatur = $user[usertext];
	$signatur .= '
	<img src="'.$code.'" alt="'.$_language->module['signature'].'" style="max-width:100%;" />';
	
	safe_query("UPDATE `".PREFIX."user` SET usertext='".$signatur."' WHERE userID='".$userID."'");
	echo '<div style="text-align: center">'.$_language->module['profil_success'].'</div>';
	redirect("index.php?site=signatur","",2);
	}

else {
	$ds=safe_query("SELECT * FROM ".PREFIX."signatur WHERE active='1'");
	$anz=mysql_num_rows($ds);
	if($anz) {
		while($sig = mysql_fetch_array($ds)) {
		$ID = $sig[sigID];
		echo'
		<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
		<tr>
			<td class="title"><b>'.$_language->module['signature'].' '.$sig[sigID].'</b></td>
		</tr>
		<tr>
			<td class="td1" align="center"><img style="max-width:550px" src="http://'.$_SERVER[HTTP_HOST].'/sig.php?id='.$userID.'&sig='.$sig[sigID].'" /></td>
		</tr>
		<tr>
			<td class="td2" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=signatur&amp;choose='.$sig[sigID].'\');return document.MM_returnValue" value="'.$_language->module['choose'].'" /></td>
		</tr>
		</table>
		
		<br />
		<hr>
		<br />';
		} 
		
	} 
	else echo $_language->module['not_entery'];
}
?>