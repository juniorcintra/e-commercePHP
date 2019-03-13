<?php 

	function formatPrice(float $vlprice){

		return number_format((float)$vlprice, 2, ",", ".");

	}

 ?>