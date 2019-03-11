<?php

    // namespace
    use Rain\Tpl;

	// include
	include "library/Rain/Tpl.php";

	// config
	$config = array(
					"base_url"      => null,
					"tpl_dir"       => "templates/nested_loop/",
					"cache_dir"     => "cache/",
					"debug"         => true // set to false to improve the speed
				   );

	Tpl::configure( $config );


	// Add PathReplace plugin
	require_once('library/Rain/Tpl/Plugin/PathReplace.php');
	Rain\Tpl::registerPlugin( new Rain\Tpl\Plugin\PathReplace() );



        $user = array(
                    array(
                        'name' => 'Jupiter',
                        'color' => 'yellow',
                        'orders' => array(
                            array('order_id' => '123', 'order_name' => 'o1d'),
                            array('order_id' => '1sn24', 'order_name' => 'o2d')
                        )
                    ),
                    array(
                        'name' => 'Mars',
                        'color' => 'red',
                        'orders' => array(
                            array('order_id' => '3rf22', 'order_name' => '¶©µ¥Aj')
                        )
                    ),
                    array(
                        'name' => 'Empty',
                        'color' => 'blue',
                        'orders' => array(
                        )
                    ),
                    array(
                        'name' => 'Earth',
                        'color' => 'blue',
                        'orders' => array(
                        array('order_id' => '2315', 'order_name' => '¶©µ¥15'),
                        array('order_id' => 'rf2123', 'order_name' => '¶©µ¥215'),
                        array('order_id' => '0231', 'order_name' => '¶©µ¥315'),
                        array('order_id' => 'sn09-0fsd', 'order_name' => '¶©µ¥45415')
                            )
                    )
                );


        // draw
	$tpl = new Tpl;
	$tpl->assign( "user", $user );
	echo $tpl->draw( "test" );


        
	class Test{
		static public function method( $variable ){
			echo "Hi I am a static method, and this is the parameter passed to me: $variable!";
		}
	}

?>