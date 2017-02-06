<?php

/**
 * This file is part of the EmailTester
 *
 * Copyright (c) 2017 Tomáš Karlík (http://tomaskarlik.cz)
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace TomasKarlik\EmailSpamTester\Serivce;

use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;


class Tester
{

	/**
	 * @var array
	 */
	private $parameters;


	public function __construct(array $parameters)
	{
		$this->parameters = $parameters;
	}

}
