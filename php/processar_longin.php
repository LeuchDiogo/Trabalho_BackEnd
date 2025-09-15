<?php
require("conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    echo "Login realizado com sucesso!";
    // aqui você pode redirecionar:
    // header("Location: ../pagina_inicial.php");
    // exit;
} else {
    echo "Email ou senha incorretos.";
}

$conexao->close();
?>