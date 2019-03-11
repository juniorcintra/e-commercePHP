<?php
\set_include_path(
	\dirname(\dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'library'
	. PATH_SEPARATOR . \get_include_path()
);
require_once 'Rain/Tpl.php';

class TplTest extends PHPUnit_Framework_TestCase
{
	private $engine = null;

	/**
	 * Sets include path to raintpl lib.
	 */
	public function setUp()
	{
		$this->configure();
		$this->engine = new \Rain\Tpl();
	}

	private function configure()
	{
		Rain\Tpl::configure(array(
			'debug' => true,
			'tpl_dir' => __DIR__ . '/_files/',
			'cache_dir' => __DIR__ . '/../../cache/',
		));
	}

	public function testCallHooks()
	{
		// Make a mock that registers to all hooks and check required context keys.
		$hooks = array(
			'before_parse' => array('code', 'template_basedir', 'template_filepath', 'conf'),
			'after_parse' => array('code', 'template_basedir', 'template_filepath', 'conf'),
		);

		// init mock plugin
		$methods = array_keys($hooks);
		$plugin = $this->getMock(
			'Rain\Tpl\IPlugin',
			array_merge(array('declare_hooks', 'set_options'), $methods)
		);
		$plugin->expects($this->once())
			->method('declare_hooks')
			->will($this->returnValue($methods));
		foreach ($hooks as $method => $required) {
			$contstrains = array();
			foreach ($required as $key) {
				$contstrains[] = $this->arrayHasKey($key);
            }
			$plugin->expects($this->once())
				->method($method)
				->with(call_user_func_array(array($this, 'logicalAnd'), $contstrains));
		}

		// register plugin and draw template
		Rain\Tpl::register_plugin($plugin);
		$this->engine->draw('template', true);
	}
}