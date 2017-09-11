<?php
//session
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

//unset variables
$USER_LOGIN = false;
unset($USER_ID);
unset($USER_NAME);
unset($USER_FULL_NAME);
unset($USER_GROUP);
unset($USER_STATE);
unset($USER_STATE_LABEL);
unset($USER_DISPLAY_NAME);

header('Location: index.php');
exit();

?>