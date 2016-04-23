<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.3.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Base class for application classes.
 *
 * The application class is responsible for bootstrapping the application,
 * and ensuring that middleware is attached. It is also invoked as the last piece
 * of middleware, and delegates request/response handling to the correct controller.
 */
abstract class BaseApplication
{

    /**
     * @var string Contains the path of the config directory
     */
    protected $configDir;

    /**
     * Constructor
     *
     * @param string $configDir The directory the bootstrap configuration is held in.
     */
    public function __construct($configDir)
    {
        $this->configDir = $configDir;
    }

    /**
     * @param \Cake\Http\MiddlewareStack $middleware The middleware stack to set in your App Class
     * @return \Cake\Http\MiddlewareStack
     */
    abstract public function middleware($middleware);

    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap()
    {
        // Load traditional bootstrap file..
        require_once $this->configDir . '/bootstrap.php';

        // Load other config files your application needs.
    }

    /**
     * Invoke the application.
     *
     * - Convert the PSR request/response into CakePHP equivalents.
     * - Create the controller that will handle this request.
     * - Invoke the controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request
     * @param \Psr\Http\Message\ResponseInterface $response The response
     * @param callable $next The next middleware
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        // Convert the request/response to CakePHP equivalents.
        $cakeRequest = RequestTransformer::toCake($request);
        $cakeResponse = ResponseTransformer::toCake($response);

        // Dispatch the request/response to CakePHP
        $cakeResponse = $this->getDispatcher()->dispatch($cakeRequest, $cakeResponse);

        // Convert the response back into a PSR7 object.
        return $next($request, ResponseTransformer::toPsr($cakeResponse));
    }

    /**
     * Get the ActionDispatcher.
     *
     * @return \Spekkoek\ActionDispatcher
     */
    protected function getDispatcher()
    {
        return new ActionDispatcher();
    }
}
