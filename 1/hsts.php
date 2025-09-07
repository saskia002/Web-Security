<?php

header_remove();
header('Strict-Transport-Security: max-age=15552000;  includeSubDomains');


$headers = headers_list();

foreach ($headers as $header) {
	echo '$header <br>';
}
