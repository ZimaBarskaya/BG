<?php
// Задаем константы:
define ('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = "http://zima-task.zzz.com.ua/";
define ('SITE_PATH', $sitePath); // путь к корневой папке сайта

define("DB_SERVER", "mysql.zzz.com.ua");
define("DB_USER", "mainAdmin");
define("DB_PASS", "Admin12345");
define("DB_NAME", "zyma_barska");

$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());


