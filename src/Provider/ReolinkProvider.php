<?php

declare(strict_types=1);

namespace App\Provider;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Client\Response;

class ReolinkProvider
{

	protected readonly string $user;
	protected readonly string $pass;
	protected readonly string $host;

	protected readonly string $url;

	protected ?string $token = null;

	public function __construct(protected readonly string $device)
	{
		$this->host = Configure::read('Reolink.' . $device . '.host') ?? throw new \Exception("Host for `{$device}` not configured");
		$this->user = Configure::read('Reolink.' . $device . '.user') ?? throw new \Exception("User for `{$device}` not configured");
		$this->pass = Configure::read('Reolink.' . $device . '.pass') ?? throw new \Exception("Pass for `{$device}` not configured");

		$this->url = sprintf("https://%s/cgi-bin/api.cgi", $this->host);

		$this->_login();
	}

	public function __destruct()
	{
		$this->_logout();
	}

	protected function _login(): bool
	{
		$request = $this->sendRequest('Login', [
			'User' => [
				'userName' => $this->user,
				'password' => $this->pass,
			],
		]);

		$body = $request->getJson()[0];

		if ($request->getStatusCode() !== 200 || ($body['code'] ?? 1) !== 0) {
			return false;
		}

		$this->token = $body['value']['Token']['name'] ?? '';

		return true;
	}

	protected function _logout(): bool
	{
		if (!$this->token) {
			return true;
		}

		$request = $this->sendRequest('Logout');

		$body = $request->getJson()[0];

		if ($request->getStatusCode() !== 200 || ($body['code'] ?? 1) !== 0) {
			return false;
		}

		$this->token = null;

		return true;
	}

	public function sendRequest(string $cmd, array $data = []): Response
	{
		$client = new Client([
			'ssl_verify_peer' => false,
			'ssl_verify_host' => false,
		]);

		$data = [
			'cmd'    => $cmd,
			'action' => 0,
			'param'  => $data,
		];

		$query = http_build_query([
			'cmd'   => $cmd,
			'token' => $this->token ?? 'null',
		]);

		$url = $this->url . '?' . $query;

		$response = $client->post(
			$url,
			'[' . json_encode($data) . ']',
			['type' => 'json']
		);

		return $response;
	}
}
