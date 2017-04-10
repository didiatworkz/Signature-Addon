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
  include("_mysql.php");
  include("_settings.php");
  include("_functions.php");
  
	$id=$_GET['id'];
	$s=$_GET['sig'];
	$user = mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."user` WHERE userID='$id' LIMIT 1"));
	$sig = mysql_fetch_array(safe_query("SELECT * FROM `".PREFIX."signatur` WHERE sigID='$s' LIMIT 1"));
		if($sig['font'] == 0)  $fontfile = "./fonts/04B_08.ttf";
		if($sig['font'] == 1)  $fontfile = "./fonts/arial.ttf";
		if($sig['font'] == 2)  $fontfile = "./fonts/opensans.ttf";
		if($sig['font'] == 3)  $fontfile = "./fonts/verdana.ttf";
		$hex = str_replace("#", "", $sig['color']);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} 
		else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		
		$size = $sig['size'];
		$image = imagecreatefromjpeg("./images/signatur/".$sig['image']);
		$img_background = imagecolorallocatealpha($image, 255, 255, 255, 127);
		$color = imagecolorallocate($image, $r, $g, $b);
		
		imagefill($image, 0, 0, $img_background);
			if($sig['avatar'] == 1) {
				if($user['avatar']) $avatar = 'images/avatars/'.$user['avatar'];
				else $avatar = 'images/avatars/noavatar.gif'; 
				if (strpos((string) $avatar,'.gif') == true) $avatar = imageCreateFromGIF($avatar);
				if (strpos((string) $avatar,'.jpg') == true) $avatar = imageCreateFromJPEG($avatar);
				if (strpos((string) $avatar,'.png') == true) $avatar = imageCreateFromPNG($avatar); 
			imagecopy($image, $avatar, $sig['avatar_X'], $sig['avatar_Y'], 0, 0, imagesx($avatar), imagesy($avatar));
			} 
			if($sig['username'] == 1) {
			imagettftext($image, $size, 0, $sig['username_X'], $sig['username_Y'], $color, $fontfile, $user['nickname']);	
			}
			if($sig['rang'] == 1) {
				if(isforumadmin($user['userID'])) {
					$rang = 'images/icons/ranks/admin.gif';
					$rang = imageCreateFromGIF($rang);
				}
				elseif(isanymoderator($user['userID'])) {
					$rang = 'images/icons/ranks/moderator.gif';
					$rang = imageCreateFromGIF($rang);
				}
				else {
					$posts = getuserforumposts($user['userID']);
					$ds = mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."forum_ranks WHERE ".$posts." >= postmin AND ".$posts." <= postmax AND postmax >0"));
					$rang = 'images/icons/ranks/'.$ds['pic'];
					$rang = imageCreateFromGIF($rang);
				}	
			imagecopy($image, $rang, $sig['rang_X'], $sig['rang_Y'], 0, 0, imagesx($rang), imagesy($rang));
			}		
			if($sig['town'] == 1) {
			imagettftext($image, $size, 0, $sig['town_X'], $sig['town_Y'], $color, $fontfile, $user['town']);	
			}
			if($sig['web'] == 1) {
			imagettftext($image, $size, 0, $sig['web_X'], $sig['web_Y'], $color, $fontfile, $user['homepage']);	
			}
			if($sig['text'] == 1) {
			imagettftext($image, $size, 0, $sig['text_X'], $sig['text_Y'], $color, $fontfile, $sig['text_field']);	
			}
		header('Cache-Control: no-cache');
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
?>