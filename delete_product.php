<?php
require_once "db.php";
require_once "auth.php";
requireLogin();

if (!isset($_GET['id'])) {
    die("ID manquant.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: products.php");
exit;
?>