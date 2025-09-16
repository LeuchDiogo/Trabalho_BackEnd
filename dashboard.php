<?php
session_start();
require("php/conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id   = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['apagar'])) {
    $data    = $_POST['data_medicao'];
    $peso    = $_POST['peso'];
    $altura  = $_POST['altura'];
    $ombro   = $_POST['ombro'];
    $abdomen = $_POST['abdomen'];
    $quadril = $_POST['quadril'];
    $peito   = $_POST['peito'];
    $braco_d = $_POST['braco_d'];
    $braco_e = $_POST['braco_e'];
    $perna_d = $_POST['perna_d'];
    $perna_e = $_POST['perna_e'];
    $panturrilha_d = $_POST['panturrilha_d'];
    $panturrilha_e = $_POST['panturrilha_e'];

    $sql = "INSERT INTO medidas_corporais
            (usuario_id, data_medicao, peso, altura, ombro, abdomen, quadril, peito,
             braco_d, braco_e, perna_d, perna_e, panturrilha_d, panturrilha_e)
            VALUES
            ($usuario_id, '$data', $peso, $altura, $ombro, $abdomen, $quadril, $peito,
             $braco_d, $braco_e, $perna_d, $perna_e, $panturrilha_d, $panturrilha_e)";
    $conexao->query($sql);
}


$result = $conexao->query(
    "SELECT * FROM medidas_corporais WHERE usuario_id = $usuario_id ORDER BY data_medicao DESC"
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="container">

    <div class="top-bar">
        <h1>Bem-vindo, <?= htmlspecialchars($usuario_nome) ?>!</h1>
        <form action="php/logout.php" method="post">
            <button type="submit">Deslogar Conta</button>
        </form>
    </div>

    <div class="box">
        <h2>Adicionar Medidas</h2>
        <form method="post">
            <div class="form-row">
                <input type="date" name="data_medicao" required>
                <input type="number" step="0.01" name="peso" placeholder="Peso">
                <input type="number" step="0.01" name="altura" placeholder="Altura">
                <input type="number" step="0.01" name="ombro" placeholder="Ombro">
                <input type="number" step="0.01" name="abdomen" placeholder="Abdômen">
                <input type="number" step="0.01" name="quadril" placeholder="Quadril">
                <input type="number" step="0.01" name="peito" placeholder="Peito">
            </div>
            <div class="form-row">
                <input type="number" step="0.01" name="braco_d" placeholder="Braço D">
                <input type="number" step="0.01" name="braco_e" placeholder="Braço E">
                <input type="number" step="0.01" name="perna_d" placeholder="Perna D">
                <input type="number" step="0.01" name="perna_e" placeholder="Perna E">
                <input type="number" step="0.01" name="panturrilha_d" placeholder="Pant D">
                <input type="number" step="0.01" name="panturrilha_e" placeholder="Pant E">
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>

    <div class="box">
        <h2>Suas Medidas</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th><th>Peso</th><th>Altura</th><th>Ombro</th><th>Abdômen</th>
                    <th>Quadril</th><th class="peito">Peito</th>
                    <th class="braco_d">Braço D</th><th class="braco_e">Braço E</th>
                    <th class="perna_d">Perna D</th><th class="perna_e">Perna E</th>
                    <th class="panturrilha_d">Pant D</th><th class="panturrilha_e">Pant E</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['data_medicao']) ?></td>
                    <td><?= $row['peso'] ?></td>
                    <td><?= $row['altura'] ?></td>
                    <td><?= $row['ombro'] ?></td>
                    <td><?= $row['abdomen'] ?></td>
                    <td><?= $row['quadril'] ?></td>
                    <td><?= $row['peito'] ?></td>
                    <td><?= $row['braco_d'] ?></td>
                    <td><?= $row['braco_e'] ?></td>
                    <td><?= $row['perna_d'] ?></td>
                    <td><?= $row['perna_e'] ?></td>
                    <td><?= $row['panturrilha_d'] ?></td>
                    <td><?= $row['panturrilha_e'] ?></td>
                    <td>
                        <form method="post" action="apagar_medida.php" onsubmit="return confirm('Deseja realmente apagar?');">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">X</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>