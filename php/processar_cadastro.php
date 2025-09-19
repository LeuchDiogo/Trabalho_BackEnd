<?php
  require("conexao.php");

  $nome  = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $data  = $_POST['data_nascimento'];
  $sexo  = $_POST['sexo'];


  $check = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
      echo "<script>
              alert('Esse e-mail já está cadastrado!');
              window.history.back();
            </script>";
      exit;
  }

  $insert = $conexao->prepare("
      INSERT INTO usuarios (nome, email, senha, data_nascimento, sexo)
      VALUES (?, ?, ?, ?, ?)
  ");

  $insert->bind_param("sssss", $nome, $email, $senha, $data, $sexo);

  if ($insert->execute()) {
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

?>