<?php
session_start();
require("conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    // Apaga somente se o registro pertencer ao usuário logado
    $sql = "DELETE FROM medidas_corporais WHERE id = $id AND usuario_id = $usuario_id";
    $conexao->query($sql);
}

header("Location: ../dashboard.php"); // volta para o dashboard
exit;
