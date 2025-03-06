<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo ) {
    if ($actual !== $proximo) {
        return true;
    } else {
        return false;
    }
}

// Funcio que revisa si el usuario esa autenticado
function isAuth(): void {
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Funcion para verificar si la sesion es de un admin
function isAdmin() : void {
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}