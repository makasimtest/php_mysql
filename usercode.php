<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

require_once __DIR__.'/vendor/autoload.php';

$mysqli = null;

function handle($data) {
    global $mysqli;

    if ($mysqli === null) {
        $mysqli = new mysqli($data['host'], $data['user'], $data['pass'], $data['db']);

        if ($mysqli->connect_errno) {
            throw new \Exception(sprintf(
                "An error occurred when trying to establish a connection to the database: %s %d",
                $mysqli->error,
                $mysqli->errno
            ));
        }
    }

    if (false == $mysqli->ping()) {
        $mysqli = null;
        throw new \Exception("Connection lost");
    }

    $select_query = "SELECT id, name, email FROM users WHERE id=".$mysqli->real_escape_string($data['id']);
    $result = $mysqli->query($select_query);
    if ($user = mysqli_fetch_array($result)) {
        $data['user'] = $user;
    }

    return $data;
}
