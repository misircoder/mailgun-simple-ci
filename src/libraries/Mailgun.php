<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailgun {

	protected $_config = array();
	protected $_initial_config = array();

	public function initialize(array $config = array())
	{
		$this->_config = $this->_initial_config = $config;
		return $this;
	}

	public function clear()
	{
		$this->_config = $this->_initial_config;
		return $this;
	}

	public function from($email, $name = FALSE)
	{
		if ($name)
		{
			$this->_config['from'] = "{$name} <{$email}>";
		}
		else
		{
			$this->_config['from'] = $email;
		}
		return $this;
	}

	public function to($email, $name = FALSE)
	{
		if ($name)
		{
			$this->_config['to'] = "{$name} <{$email}>";
		}
		else
		{
			$this->_config['to'] = $email;
		}
		return $this;
	}

	public function subject($subject)
	{
		$this->_config['subject'] = $subject;
		return $this;
	}

	public function message($message)
	{
		$this->_config['message'] = $message;
		return $this;
	}

	public function send()
	{
		return $this->_execute();
	}

	protected function _execute()
	{
		$data['from'] = $this->_config['from'];
		$data['to'] = $this->_config['to'];
		$data['subject'] = $this->_config['subject'];
		$data['html'] = $this->_config['message'];
		$data['text'] = strip_tags($this->_config['message']);

		$apikey = $this->_config['apikey'];
		$domain = $this->_config['domain'];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/{$domain}/messages");
		# AUTH
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "api:{$apikey}");
		# POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		# OTHERS
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		# EXECUTE
		$result = curl_exec($ch);
		curl_close($ch);
		# PARSE AND RETURN
		$json = json_decode($result);
		return isset($json->id) && strlen($json->id) > 2;
	}
}
