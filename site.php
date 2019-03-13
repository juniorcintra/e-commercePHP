<?php 

use \Hcode\Page;
use \Hcode\Model\Product;


$app->get('/', function() {

	$product = new Product();
	
	$products = Product::listAll();

	$page = new Page();

	$page->setTpl("index", [
		"products"=>$products
	]);	

});




 ?>