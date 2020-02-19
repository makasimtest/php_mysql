<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

require_once __DIR__.'/vendor/autoload.php';

function handle($data) {
    $pdo = new PDO($data['mysql_dsn'], $data['mysql_user'], $data['mysql_pass']);

    $stm = $pdo->prepare("SELECT * FROM users WHERE id= ?");
    $stm->bindValue(1, $data['user_id']);
    $stm->execute();

    $data['user'] = $stm->fetch(PDO::FETCH_ASSOC);

    return $data;
}
