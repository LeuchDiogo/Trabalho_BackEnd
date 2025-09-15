<?php
    $conexao = mysqli_connect("localhost","root","","treino");
    if(!$conexao){
        die('não foi possivel conectar ao banco de dados'. mysqli_error());
    }
    mysqli_set_charset($conexao, 'utf8');
