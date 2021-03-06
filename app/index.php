<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Illuminate\Database\Capsule\Manager as Capsule;


require __DIR__ . '/../vendor/autoload.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);



// Eloquent
$container = $app->getContainer();

$capsule = new Capsule();
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['MYSQL_HOST'],
    'database'  => $_ENV['MYSQL_DB'],
    'username'  => $_ENV['MYSQL_USER'],
    'password'  => $_ENV['MYSQL_PASS'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);


$capsule->setAsGlobal();
$capsule->bootEloquent();


// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->post('[/]', \UsuarioController::class . ':CargarUno');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
});

$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->post('[/]', \ProductoController::class . ':CargarUno');
    $group->get('/{nombre_producto}', \ProductoController::class . ':TraerUno');
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->post('[/]', \MesaController::class . ':CargarUno');
    $group->get('/{codigo}', \UsuarioController::class . ':TraerUno');
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->post('[/]', \PedidoController::class . ':CargarUno');
    $group->get('/{pedido}', \UsuarioController::class . ':TraerUno');
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
});

// $app->group('/clientes', function (RouteCollectorProxy $group) {
//     $group->get('[/]', \UsuarioController::class . ':TraerTodos');
//     $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
//     $group->post('[/]', \UsuarioController::class . ':CargarUno');
//     $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
//     $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
// });





// $app->group('/encuestas', function (RouteCollectorProxy $group) {
//     $group->get('[/]', \UsuarioController::class . ':TraerTodos');
//     $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
//     $group->post('[/]', \UsuarioController::class . ':CargarUno');
//     $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
//     $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
// });

// $app->get('[/]', function (Request $request, Response $response) {
//     $response->getBody()->write("Slim Framework 4 PHP");
//     return $response;
// });

$app->run();
