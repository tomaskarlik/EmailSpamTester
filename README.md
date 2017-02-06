# EmailSpamTester
Email SPAM checker for [Nette](https://github.com/nette) using [templateria/spamassassin](https://github.com/templateria/php-spamassassin).

## Configuration
```
spamassassin: TomasKarlik\EmailSpamTester\DI\EmailSpamTesterExtension

spamassassin:
	hostname: '127.0.0.1'
	port: 783
	received: TRUE #add Received header for testing
```

## Usage

```php
$message = new Nette\Mail\Message;
dump($emailTester->getSpamReport($message));
dump($emailTester->getSymbols($message));
dump($emailTester->getScore($message));
dump($emailTester->isSpam($message));
```

## Install via Composer
```
"require": {
	"tomaskarlik/emailspamtester" : "dev-master"
}
```