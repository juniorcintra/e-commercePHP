<?php 

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\Model\Cart;
use \Hcode\Model\User;
use \Hcode\Model\Address;


$app->get('/', function() {

	$product = new Product();
	
	$products = Product::listAll();

	$page = new Page();

	$page->setTpl("index", [
		"products"=>Product::checkList($products)
	]);	

});

$app->get("/category/:idcategory", function($idcategory) {

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1; 

	$category = new Category();

	$category->get((int)$idcategory);

	$pagination = $category->getProductsPage($page);

	$pages = [];

	for ($i=1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, [
			'link'=>'/category/'.$category->getidcategory().'?page='.$i,
			'page'=>$i
		]);
	}

	$page = new Page();

	$page->setTpl("category", array(
		'category'=>$category->getValues(),
		'products'=>$pagination["data"],
		'pages'=>$pages
	));
});

$app->get('/products/:desurl', function($desurl){

	$product = new Product();

	$product->getFromUrl($desurl);

	$page = new Page();

	$page->setTpl("product-detail", [

		'product'=>$product->getValues(),
		'categories'=>$product->getCategories()

	]);

});

$app->get('/cart', function(){

	$cart = Cart::getFromSession();

	$page = new Page();

	$page->setTpl("cart", [
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>Cart::getMsgError(),
		'products'=>$cart->getProducts()
	]);	

});

$app->get('/cart/:idproduct/add', function($idproduct){

	$product = new Product();

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;

	for ($i=0; $i < $qtd; $i++) { 
		$cart->addProduct($product);
	}

	$cart->addProduct($product);
	header("Location: /cart");
	exit;

});

$app->get('/cart/:idproduct/remove-single', function($idproduct){

	$product = new Product();

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product);

	header("Location: /cart");
	exit;

});

$app->get('/cart/:idproduct/remove', function($idproduct){

	$product = new Product();

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product, true);

	header("Location: /cart");
	exit;

});

$app->post('/cart/freight', function(){

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: /cart");
	exit;

});

$app->get("/checkout", function(){

	User::verifyLogin(false);

	$cart = Cart::getFromSession();

	$address = new Address();

	if (!isset($_GET['zipcode'])) {

		$_GET['zipcode'] = $cart->getdeszipcode();

	}

	if (isset($_GET['zipcode'])) {

		$address->loadFromCEP($_GET['zipcode']);

		$cart->setdeszipcode($_GET['zipcode']);

		$cart->save();

		$cart->getCalculateTotal();

	}

	if (!$address->getdesaddress()) $address->setdesaddress('');

	if (!$address->getdesnumber()) $address->setdesnumber('');

	if (!$address->getdescomplement()) $address->setdescomplement('');

	if (!$address->getdesdistrict()) $address->setdesdistrict('');

	if (!$address->getdescity()) $address->setdescity('');

	if (!$address->getdesstate()) $address->setdesstate('');

	if (!$address->getdescountry()) $address->setdescountry('');

	if (!$address->getdeszipcode()) $address->setdeszipcode('');

	$page = new Page();

	$page->setTpl("checkout", [
		'cart'=>$cart->getValues(),
		'address'=>$address->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>Address::getMsgError()
	]);

});

$app->post("/checkout", function(){

	User::verifyLogin(false);

	if (!isset($_POST['zipcode']) || $_POST['zipcode'] === '') {

		Address::setMsgError("Informe o CEP.");

		header('Location: /checkout');

		exit;

	}

	if (!isset($_POST['desaddress']) || $_POST['desaddress'] === '') {

		Address::setMsgError("Informe o endereço.");

		header('Location: /checkout');

		exit;

	}

	if (!isset($_POST['desdistrict']) || $_POST['desdistrict'] === '') {

		Address::setMsgError("Informe o bairro.");

		header('Location: /checkout');

		exit;

	}

	if (!isset($_POST['descity']) || $_POST['descity'] === '') {

		Address::setMsgError("Informe a cidade.");

		header('Location: /checkout');

		exit;

	}

	if (!isset($_POST['desstate']) || $_POST['desstate'] === '') {

		Address::setMsgError("Informe o estado.");

		header('Location: /checkout');

		exit;

	}

	if (!isset($_POST['descountry']) || $_POST['descountry'] === '') {

		Address::setMsgError("Informe o país.");

		header('Location: /checkout');

		exit;

	}

	$user = User::getFromSession();

	$address = new Address();

	$_POST['deszipcode'] = $_POST['zipcode'];

	$_POST['idperson'] = $user->getidperson();

	$address->setData($_POST);

	$address->save();

	$cart = Cart::getFromSession();

	$cart->getCalculateTotal();

	$order = new Order();

	$order->setData([
		'idcart'=>$cart->getidcart(),
		'idaddress'=>$address->getidaddress(),
		'iduser'=>$user->getiduser(),
		'idstatus'=>OrderStatus::EM_ABERTO,
		'vltotal'=>$cart->getvltotal()
	]);

	$order->save();

	switch ((int)$_POST['payment-method']) {

		case 1:
		header("Location: /order/".$order->getidorder()."/pagseguro");
		break;
		case 2:
		header("Location: /order/".$order->getidorder()."/paypal");
		break;
	}

	exit;

});

$app->get("/login", function(){

	$page = new Page();

	$page->setTpl("login", [
		'error'=>User::getError(),
		'errorRegister'=>User::getErrorRegister(),
		'registerValues'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'', 'email'=>'', 'phone'=>'']
	]);

});

$app->post("/login", function(){

	try {

		User::login($_POST['login'], $_POST['password']);

	} catch(Exception $e) {

		User::setError($e->getMessage());

	}

	header("Location: /checkout");
	exit;

});

$app->get("/logout", function(){

	User::logout();

	header("Location: /login");
	exit;
	
});



?>