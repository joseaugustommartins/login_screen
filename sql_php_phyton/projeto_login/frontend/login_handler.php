<?php
$data = [
    'username' => $_POST['username'],
    'password' => $_POST['password']
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ]
];

$context  = stream_context_create($options);
$result = @file_get_contents('http://localhost:8000/login', false, $context);

if ($result === FALSE) {
    header("Location: login.php?error=1");
    exit();
}

$response = json_decode($result, true);
if (isset($response['access_token'])) {
    session_start();
    $_SESSION['token'] = $response['access_token'];
    header('Location: dashboard.php');
} else {
    header("Location: login.php?error=1");
}
?>
