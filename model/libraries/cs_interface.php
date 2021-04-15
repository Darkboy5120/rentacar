<?php
class CSInterface {
    private $securitykey = "YFD}.L*6Qfev";
    public function getSecuritykey() {
        return $this->securitykey;
    }
    public function setCookie ($cookieName, $cookieValue) {
        setcookie($cookieName, $cookieValue, time() + 86400, "/");
    }
    public function existCookie ($cookieName) {
        return ($_COOKIE[$cookieName] === NULL) ? FALSE : TRUE;
    }
    public function getCookie ($cookieName) {
        return $_COOKIE[$cookieName];
    }
    public function setSession ($sessionName, $sessionValue) {
        $_SESSION[$sessionName] = $sessionValue;
    }
    public function existSession ($sessionName) {
        return ($_SESSION[$sessionName] === NULL) ? FALSE : TRUE;
    }
    public function getSession ($sessionName) {
        return $_SESSION[$sessionName];
    }
    public function destroy () {
        if (ini_get('session.use_cookies')) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params['path'], $params['domain'],
	        $params['secure'], $params['httponly']
            );
        }
        session_unset();
        session_destroy();
    }
    public function __construct ($life=86400) {
        session_start([
        'cookie_lifetime' => $life,
        'use_only_cookies' => 1,
        'cookie_secure' => 1,
        'cookie_httponly' => 1
        ]);
    }
}

$ci0 = new CSInterface();