# Simple Mailgun for *code igniter 3*
Simple "Mailgun" library for Code Igniter. No library required.

## Features
* Small (~ 2KB)
* No additional library required
* Mailgun API is not required

## Usage
1. Load mailgun (this) library
```php
$this->load->library('mailgun');
```

2. Initialize library
```php
$this->mailgun->initialize(array(
  'apikey' => 'key-xxxxxxxxxxxxxxxx',                             # API key provided by mailgun
  'domain' => 'example.com'                                       # Domain
));
```

3. Set required values
```php
$this->mailgun->from('account@example.com', 'First Last');        # Sender email, and name*
$this->mailgun->to('account@example.com', 'First Last');          # Receiver email, and name*
$this->mailgun->subject('Subject of the email');                  # Subject of the email
$this->mailgun->message('Message body');                          # Message body in HTML
```
_\* name is not required_

4. And send, that's all!
```php
$this->mailgun->send();
```
*`$this->mailgun->send()` will return bool value. If it's TRUE then mail was sent*
