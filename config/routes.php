<?php

declare(strict_types=1);

namespace App;

use App\Controller\{
	ValidateController
};
use Psr\Http\Message\{
	ResponseInterface,
	ServerRequestInterface
};
use Slim\App;

return function (App $app) {
	$prefix = '';

	$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
		$response->getBody()->write('Under Development');
		return $response;
	});

    $app->get('/rel-me-check', [ValidateController::class, 'rel_me_check'])
        ->setName('rel_me_check');

    $app->get('/validate-rel-me', [ValidateController::class, 'rel_me'])
        ->setName('validate_rel_me');

    $app->get('/validate-h-card', [ValidateController::class, 'h_card'])
        ->setName('validate_h_card');

    $app->get('/validate-h-entry', [ValidateController::class, 'h_entry'])
        ->setName('validate_h_entry');
};

