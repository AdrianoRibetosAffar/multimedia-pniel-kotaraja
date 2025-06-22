<?php
session_start();

// Force destroy session
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['status' => 'logged_out']);
exit();
?>