<?php
    require("conexao.php");

    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $data  = $_POST['data_nascimento'];
    $sexo  = $_POST['sexo'];

    $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento, sexo)
            VALUES ('$nome', '$email', '$senha', '$data', '$sexo')";


    mysqli_query($conexao, $sql);
    echo "Cadastro Realizado Com sucesso";

        if ($sql) {
        header("Location: ../formularios/login.html"); 
        exit;
    } else {
        echo "Erro ao cadastrar usuário.";
        }
