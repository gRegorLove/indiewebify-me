<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\{
	App,
	Factory\AppFactory,
	Interfaces\RouteParserInterface,
	Views\Twig,
	Views\TwigMiddleware
};
use Twig\TwigFunction;

return [
	'settings' => function () {
		return require __DIR__ . '/settings.php';
	},

	App::class => function (ContainerInterface $container) {
		return Bridge::create($container);
	},

	ResponseFactoryInterface::class => function (ContainerInterface $container) {
		return AppFactory::determineResponseFactory();
	},

	// The Slim RouterParser
	RouteParserInterface::class => function (ContainerInterface $container) {
		return $container->get(App::class)->getRouteCollector()->getRouteParser();
	},

	// Twig templates
	Twig::class => function (ContainerInterface $container) {
		$settings = $container->get('settings')['twig'];
		$twig = Twig::create($settings['paths'], $settings['options']);

		// example of adding a Twig function
		/*$environment = $twig->getEnvironment();

		$environment->addFunction(
			new TwigFunction('foo', function ($microformat, $property) {
				return 'bar';
			})
		);*/

		return $twig;
	},

	TwigMiddleware::class => function (ContainerInterface $container) {
		return TwigMiddleware::createFromContainer($container->get(App::class), Twig::class);
	},
];

