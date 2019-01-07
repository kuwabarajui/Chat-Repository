<?php
require('lib.php');

$message = $_POST["msg"];

$chat = new ChatAPI();
$chat->set($message);
