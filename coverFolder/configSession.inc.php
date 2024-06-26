<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'kickingdom.42web.io',
    'path' => '/',
    'secure' => $isHttps, // Change to true if using HTTPS
    'httponly' => true
]);

session_start();

if (isset($_SESSION["user_id"])){
    if (!isset($_SESSION["last_regeneration"])){
        session_regenerate_id();
        $_SESSION["last_regeneration"] = time();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval){
            regenerate_session_id();
        }
    }
} else{
    if (!isset($_SESSION["last_regeneration"])){
        session_regenerate_id();
        $_SESSION["last_regeneration"] = time();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval){
            regenerate_session_id();
        }
    }
}


function regenerate_session_id_loggedIn(){
    session_regenerate_id(true);

    $userid = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userid;
    session_id($sessionId);

    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id(){
    session_regenerate_id();
    $_SESSION["last_regeneration"] = time();
}
?>