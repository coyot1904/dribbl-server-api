<?php 

function hashing($string)
{
	$userPassword = $string;
	$constandSalt = "BilBilak!";
	//$variableSult = microtime();
	$variableSult = "123456789";
	$storedPhrase = hash('sha512',$variableSult.$userPassword.$constandSalt);
	
	return $storedPhrase;

}
?>