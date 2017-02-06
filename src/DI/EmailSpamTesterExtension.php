<?php

/**
 * This file is part of the EmailTester
 *
 * Copyright (c) 2017 Tomáš Karlík (http://tomaskarlik.cz)
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace TomasKarlik\EmailSpamTester\DI;

use Nette\DI\CompilerExtension;
use TomasKarlik\EmailSpamTester\Service\Tester;


/**
 * EmailSpamTester extension for Nette DI
 */
class EmailSpamTesterExtension extends CompilerExtension
{

	/**
	 * @var array
	 */
	public $defaults = [
		'hostname' => 'localhost',
		'port' => 783,
		'socketPath' => NULL,
		'socket' => NULL,
		'protocolVersion' => '1.5',
		'enableZlib' => FALSE
	];


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$builder->addDefinition($this->prefix('tester'))
			->setClass(Tester::class, [$config]);

		$this->compiler->parseServices($builder, $config);
	}

}
