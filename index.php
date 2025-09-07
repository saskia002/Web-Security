<?php

require_once "./headers.php";
require_once "./session.php";


$headers = getallheaders();

foreach ($headers as $header => $value) {
	echo "$header: $value <br>";
}
