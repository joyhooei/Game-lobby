<?php
session_start();
require_once("../../../includes/db_functions.inc.php");
require_once("../../../includes/config.inc.php");
require_once("../../../includes/filelist.inc.php");
$dir = $setting['sitepath'] . '/avatars';
$files = dir_list($dir);
$os = array("gif", "jpg", "jpeg", "png", "GIF", "JPG", "JPEG", "PNG");
$n = 0;
$num = 0;
$count = count($files);
if ($count==0) {
	echo '<p>No free avatars available.</p>';
	exit();
}
$avquery = yasDB_select("SELECT avatar FROM avatars WHERE userid = $_SESSION[userid]");
if ($avquery->num_rows != 0) {
	while ($avfile = $avquery->fetch_array(MYSQL_ASSOC)) {
		echo '<div class="avatar_images">
		<input type="image" class="useravatars" src="' . $setting['siteurl'] . 'avatars/' . $avfile['avatar'] . '" onclick="switchAvatar(\''.$avfile['avatar'].'\');return false">';
		echo '<center><input type="image" src="'.$setting['siteurl'].'templates/'.$setting['theme'].'/skins/'.$setting['skin'].'/images/close.png" height="15" width="15" name="avatar" value="Remove" onclick="deleteAvatar(\''.addslashes($avfile['avatar']).'\');return false"/></center></div>';
	}
}
$avquery->close();
while ($num < $count) {
	$file = $files[$num]['name'];
	$num++;
	$n++;
	$file = yasDB_clean($file);
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	if (in_array($ext, $os)) {
		echo '<div class="avatar_images">
		<input type="image" src="' . $setting['siteurl'] . 'avatars/' . $file . '"  onclick="switchAvatar(\''.$file.'\');return false" width="100px" height="100px"></div>';
	}
}
unset($files);
echo '<div class="clear"></div>';
?>