<?php
/**
 * Created by PhpStorm.
 * User: lingardssonluna
 * Date: 2017-11-23
 * Time: 11:17
 */

$host = 'localhost';
$db = 'Milletech';
$user = 'root';
$password = 'root';
$dsn = "mysql:host=$host;dbname=$db;";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false];
$pdo = new PDO($dsn, $user, $password, $options);