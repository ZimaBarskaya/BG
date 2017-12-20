<?php
// включим отображение всех ошибок
error_reporting (E_ALL); 
// подключаем конфиг
include ('config.php'); 

include ('classes' . DS . 'router.php');

// Соединяемся с БД
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());

// Подключаем ядро сайта

include ('core' . DS . 'core.php'); 

// Загружаем router
$router = new Router($registry);
// записываем данные в реестр
$registry->set ('router', $router);
// задаем путь до папки контроллеров.
$router->setPath ('controllers');
// запускаем маршрутизатор
$router->start();
