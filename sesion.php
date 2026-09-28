<?php

/* Configuración segura de la sesión */
ini_set('session.use_strict_mode', '1');

session_set_cookie_params([
    'httponly' => true,
    'secure' => false,
    'samesite' => 'Strict'
]);

session_start();

/* Tiempo máximo de inactividad: 30 minutos */
const INACTIVIDAD_MAX = 1800;

/* Expiración absoluta: 8 horas */
const SESION_MAXIMA = 28800;

/* Crear marca de tiempo de inicio */
if (!isset($_SESSION['inicio_sesion'])) {
    $_SESSION['inicio_sesion'] = time();
}

/* Crear marca de última actividad */
if (!isset($_SESSION['ultima_actividad'])) {
    $_SESSION['ultima_actividad'] = time();
}

/* Comprobar expiración por inactividad */
if (time() - $_SESSION['ultima_actividad'] > INACTIVIDAD_MAX) {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }

    session_destroy();

    header('Location: login.php');
    exit;
}

/* Comprobar expiración absoluta */
if (time() - $_SESSION['inicio_sesion'] > SESION_MAXIMA) {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }

    session_destroy();

    header('Location: login.php');
    exit;
}

/* Actualizar última actividad */
$_SESSION['ultima_actividad'] = time();

/* Guardar huella del navegador */
$agente = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (!isset($_SESSION['agente_usuario'])) {
    $_SESSION['agente_usuario'] = $agente;
}

/* Verificar que el navegador no haya cambiado */
if (!hash_equals($_SESSION['agente_usuario'], $agente)) {
    $_SESSION = [];
    session_destroy();

    header('Location: login.php');
    exit;
}