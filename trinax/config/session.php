<?php
	
	ini_set('session.hash_function', 'sha512');
	ini_set('session.hash_bits_per_character', 5);
	ini_set('session.use_only_cookies', true);
	ini_set('session.cookie_httponly',true);
	ini_set('session.use_trans_sid',false);
	ini_set('session.cookie_lifetime',0);
	
	/*
	session.cookie_httponly boolean false --> HTTP, true --> HTTPS
	Marks the cookie as accessible only through the HTTP protocol. 
	This means that the cookie won't be accessible by scripting languages, 
	such as JavaScript. This setting can effectively help to reduce identity 
	theft through XSS attacks (although it is not supported by all browsers).
	
	session.cookie_httponly boolean
	Marks the cookie as accessible only through the HTTP protocol. 
	This means that the cookie won't be accessible by scripting languages, 
	such as JavaScript. This setting can effectively help to reduce identity 
	theft through XSS attacks (although it is not supported by all browsers).
	
	session.use_trans_sid boolean
	session.use_trans_sid whether transparent sid support is enabled or not. Defaults to 0 (disabled).
	
	session.use_only_cookies boolean
    session.use_only_cookies specifies whether the module will only use cookies to store the session 
    id on the client side. Enabling this setting prevents attacks involved passing session ids in URLs. 
    This setting was added in PHP 4.3.0. Defaults to 1 (enabled) since PHP 5.3.0.
    
    session.hash_function mixed
	session.hash_function allows you to specify the hash algorithm used to generate the session IDs. 
	'0' means MD5 (128 bits) and '1' means SHA-1 (160 bits).
	Since PHP 5.3.0 it is also possible to specify any of the algorithms provided by the hash extension 
	(if it is available), like sha512 or whirlpool. A complete list of supported algorithms can be obtained 
	with the hash_algos() function.
	
	session.hash_bits_per_character integer
	session.hash_bits_per_character allows you to define how many bits are stored in each character
	 when converting the binary hash data to something readable. The possible values are 
	 '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
	
	*/
	/*
	$secure = false;
	$httponly = true; 
	$cookieParams = session_get_cookie_params(); // Gets current cookies params.
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	*/
	session_name("tidrap");
	@session_start();
	//session_regenerate_id();
	
