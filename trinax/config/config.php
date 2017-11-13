<?php 
	require_once('session.php');
	if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1' ) //local
	{
		define('DBTRINAXHOST','localhost');
		define('DBTRINAXKUSERNAME','root');
		define('DBTRINAXPASS','');
		define('DBTRINAXNAME','trinax');
		
		
		define('SHOWSQLEXCEPTION',true);
	}
	else
	{
		exit('error');
	}
	
	
	

	