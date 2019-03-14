<?php 

<<<<<<< HEAD
function formatPrice($vlprice)
{
	if (!$vlprice > 0) $vlprice = 0;
	return number_format($vlprice, 2, ",", ".");
}

?>
=======
	function formatPrice(float $vlprice){

		return number_format((float)$vlprice, 2, ",", ".");

	}

 ?>
>>>>>>> origin/master
