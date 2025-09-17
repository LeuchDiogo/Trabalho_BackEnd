<?php
require("conexao.php");

$nome  = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$data  = $_POST['data_nascimento'];
$sexo  = $_POST['sexo'];

// Verifica se o e-mail já existe
$check = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Mostra alerta e volta para o formulário
    echo "<script>
            alert('Esse e-mail já está cadastrado!');
            window.history.back();
          </script>";
    exit;
}

// Insere o usuário
$stmt = $conexao->prepare("
    INSERT INTO usuarios (nome, email, senha, data_nascimento, sexo)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssss", $nome, $email, $senha, $data, $sexo);

if ($stmt->execute()) {
    echo "<script>
            alert('Cadastro realizado com sucesso!');
            window.location.href='../index.html';
          </script>";
} else {
    echo "<script>
            alert('Erro ao cadastrar: " . addslashes($stmt->error) . "');
            window.history.back();
          </script>";
}
