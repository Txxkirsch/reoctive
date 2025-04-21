<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Exception;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    protected QueuedJobsTable $QueuedJobs;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        /** @phpstan-ignore-next-line */
        $this->QueuedJobs = $this->fetchTable('Queue.QueuedJobs');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if (
            !empty(Configure::read('Api.password'))  &&
            Configure::read('Api.password') !== $this->request->getQuery('pw', null) &&
            $this->__checkCookie() === false
        ) {
            throw new Exception('Invalid password');
        }

        if ($this->__checkCookie() === false) {
            $this->response = $this->response->withCookie(\Cake\Http\Cookie\Cookie::create(
                'reoctive',
                md5(md5('evitcoer') . 'reoctive'),
            ));
        }
    }

    private function __checkCookie(): bool
    {
        return $this->getRequest()->getCookie('reoctive') === md5(md5('evitcoer') . 'reoctive');
    }
}
