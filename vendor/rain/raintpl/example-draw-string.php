<?php

    // namespace
    use Rain\Tpl;


	memoryUsageStart();
	timerStart();

	// include
	include "library/Rain/Tpl.php";

	// config
	$config = array(
					"base_url"      => null,
					"tpl_dir"       => "templates/test/",
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
					"bad_text"	=> "Hey this is a malicious XSS <script>alert('auto_escape is set enabled by default, so this script is escaped!');</script>",
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



	$string = file_get_contents( "templates/test/test.html");


	class Test{
		static public function method( $variable ){
			echo "Hi I am a static method, and this is the parameter passed to me: $variable!";
		}
	}


	// draw
	$tpl = new Tpl;
	$tpl->assign( $var );
	echo $tpl->drawString( $string );

// -- end





//-------------------------------------------------------------
//
//	BENCHMARK/DEBUG FUNCTIONS
//
//-------------------------------------------------------------

	echo "<br>---------<br>";
	echo memoryUsage();
	echo "<br>";
	echo timer();

	/**
	 * Useful for debug, print the variable $mixed and die
	 */
	function dump( $mixed, $exit = 1 ){
		echo "<pre>dump \n---------------------- \n\n" . print_r( $mixed, true ) . "\n----------------------<pre>";
		if( $exit ) exit;
	}



	/**
	 * Save the memory used at this point
	 */
	function memoryUsageStart( $memName = "execution_time" ){
		return $GLOBALS['memoryCounter'][$memName] = memory_get_usage();
	}



	/**
	 * Get the memory used
	 */
	function memoryUsage( $memName = "execution_time", $byteFormat = true ){
		$totMem = memory_get_usage() - $GLOBALS['memoryCounter'][ $memName ];
		return $byteFormat ? byteFormat($totMem) : $totMem;
	}


//-------------------------------------------------------------
//
//					 TIME FUNCTIONS
//
//-------------------------------------------------------------

	/**
	 * Start the timer
	 */
	function timerStart( $timeName = "execution_time" ){
		$stimer = explode( ' ', microtime( ) );
		$GLOBALS['timeCounter'][$timeName] = $stimer[ 1 ] + $stimer[ 0 ];
	}

	/**
	 * Get the time passed
	 */
	function timer( $timeName = "execution_time", $precision = 10 ){
	   $etimer = explode( ' ', microtime( ) );
	   $timeElapsed = $etimer[ 1 ] + $etimer[ 0 ] - $GLOBALS['timeCounter'][ $timeName ];
	   return substr( $timeElapsed, 0, $precision );
	}


	/**
	 * Convert byte to more readable format, like "1 KB" instead of "1024".
	 * cut_zero, remove the 0 after comma ex:  10,00 => 10	  14,30 => 14,3
	 */
	function byteFormat( $size ){
		if( $size > 0 ){
			$unim = array("B","KB","MB","GB","TB","PB");
			for( $i=0; $size >= 1024; $i++ )
				$size = $size / 1024;
			return number_format($size,$i?2:0, ',', '.' )." ".$unim[$i];
		}
	}