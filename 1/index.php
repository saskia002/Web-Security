<?php

//session_name("Saskia");

//session_set_cookie_params([
//	"path"     => "/",
//	"secure"   => "true",
//	"samesite" => "Strict",
//	"httponly" => true,
//]);

//session_start();


header_remove();
header("Strict-Transport-Security: max-age=15552000;  includeSubDomains; preload");

echo ("Enabled HSTS");