<?php

function getDbConnection() {

    // 本番環境↓のみコメントアウト解除
    // $db = "quiz_app";
    // $host = "mysql643.db.sakura.ne.jp";
    // $user = "hatgpt";
    // $pass = "qwerty123";
    // $charset = 'utf8mb4';

    //ローカル環境↓のみコメントアウト解除
    $db = "quiz_app";
    $host = "localhost";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';
    

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}