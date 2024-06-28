<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ApiController;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ApiController Test Case
 *
 * @uses \App\Controller\ApiController
 */
class ApiControllerTest extends TestCase
{
	use IntegrationTestTrait;

	/**
	 * Fixtures
	 *
	 * @var list<string>
	 */
	// protected array $fixtures = [
	// 	// 'app.Api',
	// ];

	public function testEvent()
	{
		Configure::write('debug', true);
		$this->get('/api/event/deactivate?pw=' . Configure::read('Api.password'));

		$this->assertResponseOk();
		$this->assertResponseContains('Reoctive.deactivate');
	}
}
