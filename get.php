<?php

require("lib.php");

$chat = new ChatAPI();
if( array_key_exists("name", $_GET) ){
	$chat->get($_GET["name"]);
}
else{
	$chat->get();
}
