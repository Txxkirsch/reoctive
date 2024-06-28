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
	// public function test()
	// {
	// 	$provider = new ReolinkProvider('CamFlur');
	// 	$x = $provider->sendRequest('GetEmailV20');
	// 	$y = $provider->sendRequest('GetPushV20');


	// 	echo "<pre>";
	// 	print_r([$x->getJson()[0], $y->getJson()[0]]);
	// 	exit;
	// }

	public function event(string $eventName)
	{
		$query = $this->request->getQuery();
		$data  = $this->request->getData();

		$this->dispatchEvent('Reoctive.' . $eventName, compact('query', 'data'));

		return $this->response->withStatus(200)->withStringBody("Reoctive.{$eventName} triggered");
	}
}
