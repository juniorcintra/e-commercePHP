<?php 

use \Hcode\Model\User;

function formatPrice($vlprice){

	if (!$vlprice > 0) $vlprice = 0;
	return number_format($vlprice, 2, ",", ".");
}

function checkLogin($inadmin = true){

	return User::checkLogin($inadmin);
}

function getUserName(){

	$user = User::getFromSession();

	return $user->getdesperson();

}

?>