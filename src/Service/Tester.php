<?php

/**
 * This file is part of the EmailTester
 *
 * Copyright (c) 2017 Tomáš Karlík (http://tomaskarlik.cz)
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace TomasKarlik\EmailSpamTester\Service;

use Nette\Mail\Message;
use Spamassassin\Client;
use Spamassassin\Client\Result;


class Tester
{

	/**
	 * @var Client
	 */
	static private $client = NULL;

	/**
	 * @var array
	 */
	private $parameters;


	public function __construct(array $parameters)
	{
		$this->parameters = $parameters;
	}


	/**
	 * @param Message $message
	 * @return bool
	 */
	public function isSpam(Message $message)
	{
		$client = $this->getClient();
		$body = $message->generateMessage();

		return $client->isSpam($body);
	}


	/**
	 * @param Message $message
	 * @return float
	 */
	public function getScore(Message $message)
	{
		$client = $this->getClient();
		$body = $message->generateMessage();

		return $client->getScore($body);
	}


	/**
	 * @param Message $message
	 * @return Result
	 */
	public function getSpamReport(Message $message)
	{
		$client = $this->getClient();
		$body = $message->generateMessage();

		return $client->getSpamReport($body);
	}


	/**
	 * @param Message $message
	 * @return array
	 */
	public function getSymbols(Message $message)
	{
		$client = $this->getClient();
		$body = $message->generateMessage();

		return $client->symbols($body);
	}


	/**
	 * @return bool
	 */
	public function ping()
	{
		return $this->getClient()->ping();
	}


	/**
	 * @return Client
	 */
	final public function getClient()
	{
		if ( ! self::$client) {
		    self::$client = new Client($this->parameters);
		}

		return self::$client;
	}

}
