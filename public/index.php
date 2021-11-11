<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use tatiana\first\FeedbackStore;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$feedbackStore = new FeedbackStore();

$app->get('/', function (Request $request, Response $response, $args) use ($feedbackStore){
    $temp=$feedbackStore->returnFeedBack();
    $response->getBody()->write((string)$temp);
    return $response;
});

$app->run();
