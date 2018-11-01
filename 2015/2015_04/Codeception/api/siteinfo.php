<?php
include_once __DIR__ . '/../vendor/autoload.php';

$userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_STRING);
$accessToken = filter_input(INPUT_GET, 'accessToken', FILTER_SANITIZE_STRING);

$result = ['msg' => 'something went wrong'];

if (!$userId || !$accessToken) {
    $result['msg'] = 'Missing Parameter';
    echo json_encode($result);
    die;
}

if ($userId == 'testUser') {
    if ($accessToken == 'testAccessToken') {
        $result['group name'] = 'Modern PHP';
    } else {
        $result['msg'] = 'Invalid Access Token';
    }
}

echo json_encode($result);