<?php

session_name("Saskia");

session_set_cookie_params([
	"path"     => "/",
	"secure"   => "true",
	"samesite" => "Strict",
	"httponly" => true,
]);

session_start();