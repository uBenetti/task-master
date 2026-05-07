<?php

// AUTOLOAD DAS CLASSES
spl_autoload_register(function ($class) {

    $dirs = ['Model', 'Controller', 'View'];

    foreach ($dirs as $dir) {

        $file = __DIR__ . "/src/$dir/$class.php";

        if (file_exists($file)) {

            require_once $file;
        }
    }
});

// CONEXÃO COM O BANCO
$pdo = new PDO(
    'sqlite:' . __DIR__ . '/tasks.sqlite'
);

$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

// INSTANCIA O CONTROLLER
$controller = new TaskController($pdo);

// DEFINE A ACTION
$action = $_GET['action'] ?? 'index';

// EXECUTA O MÉTODO
if (method_exists($controller, $action)) {

    $controller->$action();

} else {

    echo "Página não encontrada 404";
}

?>