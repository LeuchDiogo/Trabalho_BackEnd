<?php
    session_start();
    require("conexao.php");

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome 
            FROM usuarios
            WHERE email = '$email' 
            AND senha = '$senha'";
    $result = $conexao->query($sql);

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "<script>
                alert('Email ou senha incorretos!');
                window.history.back();
            </script>";
    }

$conexao->close();
