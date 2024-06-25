<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\ReolinkProvider;

/**
 * Api Controller
 *
 */
class ApiController extends AppController
{
	public function event(string $eventName)
	{
		$query = $this->request->getQuery();
		$data  = $this->request->getData();

		$this->dispatchEvent('Reoctive.' . $eventName, compact('query', 'data'));

		return $this->response->withStatus(200)->withStringBody("Reoctive.{$eventName} triggered");
	}
}
