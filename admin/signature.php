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


$filepath = "../images/signature/";

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);


	echo'<h1>&curren; '.$_language->module['headline'].'</h1>';
	echo '<br />';
	echo '<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=signatur&amp;action=new\');return document.MM_returnValue" value="'.$_language->module['new'].'" />';
	echo '<br /><br />';

if($_GET["action"]=="new") {
	safe_query("INSERT INTO `".PREFIX."signature` (`sigID`, `active`, `color`, `image`, `font`, `size`, `avatar`, `avatar_X`, `avatar_Y`, `username`, `username_X`, `username_Y`, `rang`, `rang_X`, `rang_Y`, `town`, `town_X`, `town_Y`, `web`, `web_X`, `web_Y`, `text`, `text_field`, `text_X`, `text_Y`) VALUES
('', 0, '#000000', 'demo.jpg', '0', '6', '1', '220', '10', '1', '65', '30', '1', '225', '94', '1', '65', '46', '1', '65', '70', '1', '".$_language->module['sql_sample']."', '65', '86');");
	redirect("admincenter.php?site=signatur","",0);
}
elseif($_POST["save"]) {
	$flyer=$_FILES["flyer"];
	$insertname = $flyer[name];
	$chkbox = array('avatar', 'username', 'rang', 'town', 'web', 'active', 'text');
	$check = 'check'.$_GET['sigID'];
	echo $check;
	$check = $_POST[$check];
	
	
	
	
	$values = array();
		foreach($chkbox as $selection ) {     
			if(in_array($selection, $check)) { 
				$values[ $selection ] = 1; 
			}
			else { 
				$values[ $selection ] = 0;  
			}
		}
	 
	if($_GET['sigID']) {
		if($flyer[name]=="") {
			if(safe_query("UPDATE `".PREFIX."signature` SET `active`='".$values['active']."', `avatar`='".$values['avatar']."', `username`='".$values['username']."', `rang`='".$values['rang']."', `town`='".$values['town']."', `web`='".$values['web']."', `text`='".$values['text']."', `text_field`='".$_POST['text_field']."', `color`='".$_POST['color']."', `font`='".$_POST['font']."', `size`='".$_POST['size']."', `avatar_X`='".$_POST['avatar_X']."', `avatar_Y`='".$_POST['avatar_Y']."', `username_X`='".$_POST['username_X']."', `username_Y`='".$_POST['username_Y']."', `rang_X`='".$_POST['rang_X']."', `rang_Y`='".$_POST['rang_Y']."', `town_X`='".$_POST['town_X']."', `town_Y`='".$_POST['town_Y']."', `web_X`='".$_POST['web_X']."', `web_Y`='".$_POST['web_Y']."', `text_X`='".$_POST['text_X']."', `text_Y`='".$_POST['text_Y']."'  WHERE `sigID`='".$_GET['sigID']."'"))
				redirect("admincenter.php?site=signatur","",0);
		} 
		else {
			$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."signature WHERE sigID='".$_GET["sigID"]."'"));
			if($insertname !== 'demo.jpg') @unlink("../images/signature/$ds[image]");
			$file_ext=strtolower(substr($flyer[name], strrpos($flyer[name], ".")));
			if($file_ext==".jpg" OR $file_ext==".jpeg" OR $file_ext==".png" OR $file_ext==".gif") {
				move_uploaded_file($flyer[tmp_name], $filepath.$flyer[name]);
				@chmod($filepath.$flyer[name], 0644);
					
				if(safe_query("UPDATE `".PREFIX."signature` SET `image`='".$insertname."', `active`='".$values['active']."', `avatar`='".$values['avatar']."', `username`='".$values['username']."', `rang`='".$values['rang']."', `town`='".$values['town']."', `web`='".$values['web']."', `text`='".$values['text']."', `text_field`='".$_POST['text_field']."', `color`='".$_POST['color']."', `font`='".$_POST['font']."', `size`='".$_POST['size']."', `avatar_X`='".$_POST['avatar_X']."', `avatar_Y`='".$_POST['avatar_Y']."', `username_X`='".$_POST['username_X']."', `username_Y`='".$_POST['username_Y']."', `rang_X`='".$_POST['rang_X']."', `rang_Y`='".$_POST['rang_Y']."', `town_X`='".$_POST['town_X']."', `town_Y`='".$_POST['town_Y']."', `web_X`='".$_POST['web_X']."', `web_Y`='".$_POST['web_Y']."', `text_X`='".$_POST['text_X']."', `text_Y`='".$_POST['text_Y']."'  WHERE `sigID`='".$_GET['sigID']."'")) {
						redirect("admincenter.php?site=signatur","",0);
					}
			} 
			else echo'<b>'.$_language->module['error_jpg'].'</b><br /><br /><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
		}
	} else echo'<b>'.$_language->module['error'].'</b><br /><br /><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
	 
}
elseif($_GET["delete"]) {
 
 $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."signature WHERE sigID='".$_GET["sigID"]."'"));
	if($ds[image] !== 'demo.jpg') @unlink("../images/signature/$ds[image]");

	safe_query("DELETE FROM ".PREFIX."signature WHERE sigID='".$_GET["sigID"]."'");
	redirect("admincenter.php?site=signatur","",0);
}
else {
	$ds=safe_query("SELECT * FROM ".PREFIX."signature ORDER BY sigID");
	$anz=mysql_num_rows($ds);
	if($anz) {
		while($show = mysql_fetch_array($ds)) {
		$ID = $show[sigID];
		$checked = 'checked';
		if ($show[active] == '1') $show[active] = $checked;
		if ($show[avatar] == '1') $show[avatar] = $checked;
		if ($show[username] == '1') $show[username] = $checked;
		if ($show[rang] == '1') $show[rang] = $checked;
		if ($show[town] == '1') $show[town] = $checked;
		if ($show[web] == '1') $show[web] = $checked;
		if ($show[text] == '1') $show[text] = $checked;
	$d_size = "<option value='6'>6</option>
			   <option value='8'>8</option>
			   <option value='10'>10</option>
			   <option value='12'>12</option>
		   	   <option value='14'>14</option>
			   <option value='16'>16</option>
			   <option value='18'>18</option>";
	$d_size = str_replace("value='".$show['size']."'","value='".$show['size']."' selected='selected'",$d_size);
	
	$d_font = "<option value='0'>04B_08</option>
			   <option value='1'>Arial</option>
			   <option value='2'>OpenSans</option>
			   <option value='3'>Verdana</option>";
	$d_font = str_replace("value='".$show['font']."'","value='".$show['font']."' selected='selected'",$d_font);
	
		echo'<form method="post" action="admincenter.php?site=signatur&sigID='.$show[sigID].'" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
	<tr>
		<td class="title">'.$_language->module['signature'].' '.$show[sigID].'</td>
	</tr>
	<tr>
		<td class="td1" align="center"><img style="max-width:600px" src="../sig.php?id='.$userID.'&sig='.$show[sigID].'" /></td>
	</tr>
	<tr>
		<td class="td1">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
				<tr>
					<td class="title"></td>
					<td class="title"><b>'.$_language->module['option'].'</b></td>
					<td class="title" width="15%" align="center"><b>'.$_language->module['w&h'].'</b></td>
					<td class="title" width="13%"></td>
					<td class="title"></td>
					<td colspan=“2“ class="title"></td>
				</tr>
				<tr>
					<td class="td1"><input type="checkbox" name="check'.$show[sigID].'[]" value="avatar" '.$show[avatar].' /></td>
					<td class="td1">'.$_language->module['avatar'].'</td>
					<td class="td1" align="center"><input type="text" name="avatar_X" value="'.$show[avatar_X].'" size="3" /> x
					<input type="text" name="avatar_Y" value="'.$show[avatar_Y].'" size="3" /></td>
					<td class="td1"></td>
					<td class="td1"><span style="color: '.$show['color'].'">'.$_language->module['fontcolor'].'</span></td>
					<td class="td1"><input type="text" name="color" value="'.$show[color].'" /></td>
				</tr>
				<tr>
					<td class="td2"><input type="checkbox" name="check'.$show[sigID].'[]" value="username" '.$show[username].' /></td>
					<td class="td2">Username</td>
					<td class="td2" align="center"><input type="text" name="username_X" value="'.$show[username_X].'" size="3" /> x
					<input type="text" name="username_Y" value="'.$show[username_Y].'" size="3" /></td>
					<td class="td2"></td>
					<td class="td2">'.$_language->module['font'].'</td>
					<td class="td2"><select name="font">'.$d_font.'</select></td>
				</tr>
				<tr>
					<td class="td1"><input type="checkbox" name="check'.$show[sigID].'[]" value="rang" '.$show[rang].' /></td>
					<td class="td1">'.$_language->module['rank'].'</td>
					<td class="td1" align="center"><input type="text" name="rang_X" value="'.$show[rang_X].'" size="3" /> x
					<input type="text" name="rang_Y" value="'.$show[rang_Y].'" size="3" /></td>
					<td class="td1"></td>
					<td class="td1">'.$_language->module['size'].'</td>
					<td class="td1"><select name="size">'.$d_size.'</select>
					</td>
				</tr>
				<tr>
					<td class="td2"><input type="checkbox" name="check'.$show[sigID].'[]" value="town" '.$show[town].' /></td>
					<td class="td2">'.$_language->module['town'].'</td>
					<td class="td2" align="center"><input type="text" name="town_X" value="'.$show[town_X].'" size="3" /> x
					<input type="text" name="town_Y" value="'.$show[town_Y].'" size="3" /></td>
					<td class="td2"></td>
					<td class="td1">'.$_language->module['image'].'<br /> <i>(max. 500x170)</i></td>
					<td class="td1"><input name="flyer" type="file"></td>
				</tr>
				<tr>
					<td class="td1"><input type="checkbox" name="check'.$show[sigID].'[]" value="web" '.$show[web].' /></td>
					<td class="td1">Website</td>
					<td class="td1" align="center"><input type="text" name="web_X" value="'.$show[web_X].'" size="3" /> x
					<input type="text" name="web_Y" value="'.$show[web_Y].'" size="3" /></td>
					<td class="td1"></td>
					<td class="td1"></td>
					<td class="td1" align="center"><input type="checkbox" name="check'.$show[sigID].'[]" value="active" '.$show[active].' /> '.$_language->module['activate'].'</td>
				</tr>
				<tr>
					<td class="td2"><input type="checkbox" name="check'.$show[sigID].'[]" value="text" '.$show[text].' /></td>
					<td class="td2"><input type="text" name="text_field" value="'.$show[text_field].'" /></td>
					<td class="td2" align="center"><input type="text" name="text_X" value="'.$show[text_X].'" size="3" /> x
					<input type="text" name="text_Y" value="'.$show[text_Y].'" size="3" /></td>
					<td class="td2"></td>
					<td class="td2"></td>
					<td class="td2" align="center"><input name="save" type="submit" value="'.$_language->module['save'].'" /> <input onClick="MM_confirm(\''.$_language->module['delete_text'].'\', \'admincenter.php?site=signatur&delete=true&sigID='.$show[sigID].'\')" type="button" value="'.$_language->module['delete'].'" /></form></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	</table>
	<br />
	<hr>
	<br />';
		} 
		
	} else echo'Keine Eintr&auml;ge';
}
?>