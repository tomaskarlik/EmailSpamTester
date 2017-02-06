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
use Nette\Utils\Random;
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
		$body = $this->generateRawMessage($message);

		return $client->isSpam($body);
	}


	/**
	 * @param Message $message
	 * @return float
	 */
	public function getScore(Message $message)
	{
		$client = $this->getClient();
		$body = $this->generateRawMessage($message);

		return $client->getScore($body);
	}


	/**
	 * @param Message $message
	 * @return Result
	 */
	public function getSpamReport(Message $message)
	{
		$client = $this->getClient();
		$body = $this->generateRawMessage($message);

		return $client->getSpamReport($body);
	}


	/**
	 * @param Message $message
	 * @return array
	 */
	public function getSymbols(Message $message)
	{
		$client = $this->getClient();
		$body = $this->generateRawMessage($message);

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
			$keys = array_flip([
				'hostname',
				'port',
				'socketPath',
				'socket',
				'protocolVersion',
				'enableZlib'
			]);
			$parameters = array_intersect_key($this->parameters, $keys);
			self::$client = new Client($parameters);
		}

		return self::$client;
	}


	/**
	 * @param Message $message
	 * @return string
	 */
	private function generateRawMessage(Message $message)
	{
		if (isset($this->parameters['received']) && $this->parameters['received']) {
			if ($message->getHeader('To') === NULL) { //default To header for testing
				$message->addTo('user@mail.local');
			}

			if ($message->getHeader('Received') === NULL) { //default Received header for testing - RCVD_REMOVED
				$to = $message->getHeader('To');
				$message->setHeader('Received', sprintf("from localhost (localhost [127.0.0.1]) by localhost (Postfix) with ESMTP id %s for <%s>; %s",
					Random::generate(10), key($to), date('r')));
			}
		}

		return $message->generateMessage();
	}

}
