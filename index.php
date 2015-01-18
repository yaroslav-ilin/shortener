<?php

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', rtrim(__DIR__, DS) . DS);

require APP_ROOT . 'vendor' . DS . 'autoload.php';

$storage = parse_ini_file('data.ini', TRUE);

$app = new \Slim\Slim();

$app->notFound(function () use ($app) {
    $app->render('404.html');
});

$app->get('/', function () use ($app) {
	$app->render('index.html');
});

$app->get('/:url', function ($url) use ($storage, $app) {
	if (!isset($storage['urls'][$url])) { $app->pass(); }

	$app->redirect($storage['urls'][$url], 303);
});

$app->get('/:url/json', function ($url) use ($storage, $app) {
	if (!isset($storage['urls'][$url])) { $app->pass(); }

	$callbackName = $app->request->get('cb');
	$app->response->headers->set('Content-Type', $callbackName ? 'application/javascript' : 'application/json');

	$json = json_encode([ 'url' => $storage['urls'][$url] ]);
	$resp =  $callbackName ? $callbackName . '(' . $json . ');' : $json;
	echo $resp;
})->name('json');

$app->get('/:url/qr', function ($url) use ($storage, $app) {
	if (!isset($storage['urls'][$url])) { $app->pass(); }

	$app->response->headers->set('Content-Type', 'image/png');

	$qrCode = new Endroid\QrCode\QrCode();
	$qrCode
	    ->setText($storage['urls'][$url])
	    ->setSize($app->request->get('size', 500))
	    ->setPadding($app->request->get('pad', 0))
	    ->setErrorCorrection('high')
	    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
	    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 255))
	    ->render()
	;
})->name('qr');

$app->run();


