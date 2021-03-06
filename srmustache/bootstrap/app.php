<?php

    //include dos Controllers

    require  __DIR__ . '/../app/Controllers/Controller.php';
    require  __DIR__ . '/../app/Controllers/HomeController.php';
    require  __DIR__ . '/../app/Controllers/LoginController.php';
    require  __DIR__ . '/../app/Controllers/MembroController.php';
	require  __DIR__ . '/../app/Controllers/ProdutoController.php';
    require  __DIR__ . '/../app/Controllers/CartaoController.php';

    //Include dos Middleware

    require  __DIR__ . '/../app/Middleware/Middelware.php';
    require  __DIR__ . '/../app/Middleware/AuthMiddelware.php';
    require  __DIR__ . '/../app/Middleware/UserMiddelware.php';

    //Include de outras classes

    require  __DIR__ . '/../app/Auth/Auth.php';

    //bootstrap
    //será colocado todas as inicializações de configurações iniciais

    // Create and configure Slim app
    $config = ['settings' => [
        'addContentLengthHeader' => false,
        'displayErrorDetails' => true,
        'db' => [
			'driver' 	=> 'mysql',
			'host' 		=> 'localhost',
			'database' 	=> 'mustache',
			'username' 	=> 'root',
			'password' 	=> '',
			'charset' 	=> 'utf8',
			'collation'	=> 'utf8_unicode_ci',
			'prefix'	=> '',
		]
    ]];

    $app = new \Slim\App($config);

    $container = $app->getContainer();

    // add Slim Flash messages
    // $container['flash'] = function () {
    //     return new \Slim\Flash\Messages();
    // };

    //seta o orm
    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $container['db'] = function ($container) use ($capsule){
        return $capsule;
    };

    $container['auth'] = function($container){
        return new \App\Auth\Auth;
    };

    //Registrando os controllers

    $container['HomeController'] = function($container){
        return new \App\Controllers\HomeController($container);
    };

    $container['LoginController'] = function($container){
        return new \App\Controllers\LoginController($container);
    };

    $container['MembroController'] = function($container){
        return new \App\Controllers\MembroController($container);
    };

	$container['ProdutoController'] = function($container){
        return new \App\Controllers\ProdutoController($container);
    };

    $container['CartaoController'] = function($container){
        return new \App\Controllers\CartaoController($container);
    };

    $container['view'] = function ($c) {
        $view = new \Slim\Views\Twig(dirname(__FILE__) . '/../Templates');

        // Instantiate and add Slim specific extension
        $router = $c->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));


        //a view ascessa as flash messages
        // $view->getEnvironment()->addGlobal('flash', $container->flash);

        return $view;
    };

    require  __DIR__ . '/../app/routes.php';

    $app->run();

?>