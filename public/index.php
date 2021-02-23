<?php

use App\Actions\ApplicationHealthCheckAction;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

/**
 * Database
 */
$validApplications = [
    'dummy-application',
    'my-new-website',
    'other-website',
    'app-dummy',
];

/**
 * Container
 */
$container = new League\Container\Container();
$container->add(ApplicationHealthCheckAction::class)
    ->addArgument($validApplications);


/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/applications/{appName}/health-check',
    function (Request $request, Response $response, $args) use ($container) {
        $appName = $args['appName'];

        $applicationHealthCheck = $container->get(ApplicationHealthCheckAction::class);

        $statusCode = $applicationHealthCheck->confirm($appName)
            ? StatusCodeInterface::STATUS_ACCEPTED
            : StatusCodeInterface::STATUS_NOT_FOUND;

        $finalResponse = $response->withStatus($statusCode);
        $finalResponse->getBody()
            ->write("{}");

        return $finalResponse;
    });

// Run app
$app->run();
