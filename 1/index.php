<?php

require_once "./headers.php";
require_once "./session.php";


$headers = headers_list();

foreach ($headers as $header) {
	echo "$header <br>";
}
