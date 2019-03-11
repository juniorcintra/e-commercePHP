<?php

    // namespace
    use Rain\Tpl;

	// include
	include "library/Rain/Tpl.php";
	
	// configure
	$config = array(
					"base_url"      => null,
					"tpl_dir"       => "templates/",
					"cache_dir"     => "cache/",
					"debug"         => true // set to false to improve the speed
				   );
	Tpl::configure( $config );


	// Add PathReplace plugin
	require_once('library/Rain/Tpl/Plugin/PathReplace.php');
	Rain\Tpl::registerPlugin( new Rain\Tpl\Plugin\PathReplace() );



	// set variables
	$var = array(
					"variable"	=> "Hello World!",
					"version"	=> "3.0 Alpha",
					"menu"		=> array(
											array("name" => "Home", "link" => "index.php", "selected" => true ),
											array("name" => "FAQ", "link" => "index.php/FAQ/", "selected" => null ),
											array("name" => "Documentation", "link" => "index.php/doc/", "selected" => null )
										),
					"week"		=> array( "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ),
					"user"		=> (object) array("name"=>"Rain", "citizen" => "Earth", "race" => "Human" ),
					"numbers"	=> array( 3, 2, 1 ),
					"bad_text"	=> 'Hey this is a malicious XSS <script>alert(1);</script>',
					"table"		=> array( array( "Apple", "1996" ), array( "PC", "1997" ) ),
					"title"		=> "Rain TPL 3 - Easy and Fast template engine", 
					"copyright" => "Copyright 2006 - 2012 Rain TPL<br>Project By Rain Team",

				);

	// add a function
	Tpl::registerTag(	"({@.*?@})", // preg split
                                "{@(.*?)@}", // preg match
                                function( $params ){ // function called by the tag
                                    $value = $params[0];
                                    return "Translate: <b>$value</b>";
				} 
                        );

	// draw
	$tpl = new Tpl;
	$tpl->assign( $var );
	echo $tpl->draw( "bootstrap/hero" );

        
?>