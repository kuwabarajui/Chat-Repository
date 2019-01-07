<?php

require("lib.php");

$id = $_POST["id"];
$pw = $_POST["pw"];

$chat = new ChatAPI();
$chat->auth($id, $pw);
