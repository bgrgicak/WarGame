<?php

require_once('bin/battle.php');


if(isset($_GET['army1']) && isset($_GET['army2']) && is_numeric($_GET['army1']) && is_numeric($_GET['army2'])){
	$battle  =new battle(array($_GET['army1'],$_GET['army2'])); //start battle
	echo 'Army'.$battle->winner().' won';
}
else{
	echo "Set army1 and army2 query string (number)";
}


?>