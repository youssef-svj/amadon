<?php
session_start();

function isLogged()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}
?>