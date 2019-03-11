<?php

    // namespace
    use Rain\Tpl;

	// include
	include "library/Rain/Tpl.php";

    // extends Rain to add getter and setter
	class MyRainTPL extends Tpl{

        // get function
        function __get( $key = null ){
            return $key ? $this->var[$key] : $this->var;
        }

        // set function
        function __set( $key, $value ){
            $this->var[$key] = $value;
        }

	}

	// conf
	$config = array( 
					"base_url"	=> null, 
					"tpl_dir"	=> "templates/raintpl3/",
					"cache_dir"	=> "cache/",
					"debug"         => true, // set to false to improve the speed
					"charset"	=> "Something different",
				   );

	//use Rain;
	MyRainTPL::configure( $config );


	// Add PathReplace plugin
	require_once('library/Rain/Tpl/Plugin/PathReplace.php');
	MyRainTPL::registerPlugin( new Rain\Tpl\Plugin\PathReplace() );


	global $global_variable;
	$global_variable = "I'm Global";

	// draw
	$tpl = new MyRainTPL;
	$tpl->variable = "Hello World";
	$tpl->version = "3.0 Alpha";
	$tpl->menu = array(
											array("name" => "Home", "link" => "index.php", "selected" => true ),
											array("name" => "FAQ", "link" => "index.php/FAQ/", "selected" => null ),
											array("name" => "Documentation", "link" => "index.php/doc/", "selected" => null )
										);
    $tpl->title = "Rain TPL 3 - Easy and Fast template engine";
    $tpl->copyright = "Copyright 2006 - 2012 Rain TPL<br>Project By Rain Team";


    $tpl->draw( 'page' );

    

        
?>