<?php

require_once __DIR__ . '/sesion.php';

/* Autenticación: comprobar que existe una sesión */
if (
    empty($_SESSION['usuario_id']) ||
    empty($_SESSION['rol'])
) {
    header('Location: login.php');
    exit;
}