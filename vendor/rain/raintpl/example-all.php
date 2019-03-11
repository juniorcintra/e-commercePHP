<?php

    // namespace
    use Rain\Tpl;

	// include
	include "library/Rain/Tpl.php";

	// config
	$config = array(
					"base_url"      => null,
					"tpl_dir"       => "templates/test/",
					"cache_dir"     => "cache/",
					"debug"         => true, // set to false to improve the speed
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
					"bad_text"	=> 'Hey this is a malicious XSS <script>alert("auto_escape is always enabled");</script>',
					"table"		=> array( array( "Apple", "1996" ), array( "PC", "1997" ) ),
					"title"		=> "Rain TPL 3 - Easy and Fast template engine", 
					"copyright" => "Copyright 2006 - 2012 Rain TPL<br>Project By Rain Team",

				);

	// add a tag
	Tpl::registerTag(	"({@.*?@})", // preg split
						"{@(.*?)@}", // preg match
						function( $params ){ // function called by the tag
												$value = $params[1][0];
												return "Translate: <b>$value</b>";
										   } 
					 );


	// add a tag
	Tpl::registerTag(	"({%.*?%})", // preg split
						"{%(.*?)(?:\|(.*?))%}", // preg match
						function( $params ){ // function called by the tag
												$value = $params[1][0];
                                                $value2 = $params[2][0];

												return "Translate: <b>$value</b> in <b>$value2</b>";
										   }
					 );

	// draw
	$tpl = new Tpl;
	$tpl->assign( $var );
	echo $tpl->draw( "test" );


        
	class Test{
		static public function method( $variable ){
			echo "Hi I am a static method, and this is the parameter passed to me: $variable!";
		}
	}

?>