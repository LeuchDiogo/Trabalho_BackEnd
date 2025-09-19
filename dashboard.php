<?php
    session_start();
    require("php/conexao.php");

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.html");
        exit;
    }

    $usuario_id   = $_SESSION['usuario_id'];
    $usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';

    $editar_id = $_POST['editar_id'] ?? null;
    $editar_dados = null;

    if ($editar_id) {
        $stmt = $conexao->prepare("SELECT * FROM medidas_corporais WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $editar_id, $usuario_id);
        $stmt->execute();
        $result_editar = $stmt->get_result();
        $editar_dados = $result_editar->fetch_assoc();
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['apagar'])) {

        $id_editar = $_POST['id_editar'] ?? null;
        $data    = $_POST['data_medicao'] ?? null;
        $peso    = $_POST['peso'] ?? null;
        $altura  = $_POST['altura'] ?? null;
        $ombro   = $_POST['ombro'] ?? null;
        $abdomen = $_POST['abdomen'] ?? null;
        $quadril = $_POST['quadril'] ?? null;
        $peito   = $_POST['peito'] ?? null;
        $braco_d = $_POST['braco_d'] ?? null;
        $braco_e = $_POST['braco_e'] ?? null;
        $perna_d = $_POST['perna_d'] ?? null;
        $perna_e = $_POST['perna_e'] ?? null;
        $panturrilha_d = $_POST['panturrilha_d'] ?? null;
        $panturrilha_e = $_POST['panturrilha_e'] ?? null;

        if ($data && $peso && $altura && $ombro && $abdomen && $quadril && $peito &&
            $braco_d && $braco_e && $perna_d && $perna_e && $panturrilha_d && $panturrilha_e) {

            if ($id_editar) {
                $stmt = $conexao->prepare("UPDATE medidas_corporais SET
                    data_medicao=?, peso=?, altura=?, ombro=?, abdomen=?, quadril=?, peito=?,
                    braco_d=?, braco_e=?, perna_d=?, perna_e=?, panturrilha_d=?, panturrilha_e=?
                    WHERE id=? AND usuario_id=?");

                $stmt->bind_param("sddddddddddddii",
                    $data, $peso, $altura, $ombro, $abdomen, $quadril, $peito,
                    $braco_d, $braco_e, $perna_d, $perna_e, $panturrilha_d, $panturrilha_e,
                    $id_editar, $usuario_id
                );
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $conexao->prepare("INSERT INTO medidas_corporais
                    (usuario_id, data_medicao, peso, altura, ombro, abdomen, quadril, peito,
                    braco_d, braco_e, perna_d, perna_e, panturrilha_d, panturrilha_e)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isdddddddddddd",
                    $usuario_id, $data, $peso, $altura, $ombro, $abdomen, $quadril, $peito,
                    $braco_d, $braco_e, $perna_d, $perna_e, $panturrilha_d, $panturrilha_e
                );
                $stmt->execute();
                $stmt->close();
            }

            $editar_dados = null;
        }
    }


    $result = $conexao->query("SELECT * FROM medidas_corporais WHERE usuario_id = $usuario_id ORDER BY data_medicao DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="shortcut icon" href="css/favicon.ico" type="image/x-icon">
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
            <h2><?= $editar_dados ? 'Editar Medidas' : 'Adicionar Medidas' ?></h2>
            <form method="post">
                <?php if($editar_dados): ?>
                    <input type="hidden" name="id_editar" value="<?= $editar_dados['id'] ?>">
                <?php endif; ?>
                <div class="form-row">
                    <input type="date" name="data_medicao" required value="<?= $editar_dados['data_medicao'] ?? '' ?>">
                    <input type="number" step="0.01" name="peso" placeholder="Peso" required value="<?= $editar_dados['peso'] ?? '' ?>">
                    <input type="number" step="0.01" name="altura" placeholder="Altura" required value="<?= $editar_dados['altura'] ?? '' ?>">
                    <input type="number" step="0.01" name="ombro" placeholder="Ombro" required value="<?= $editar_dados['ombro'] ?? '' ?>">
                    <input type="number" step="0.01" name="abdomen" placeholder="Abdômen" required value="<?= $editar_dados['abdomen'] ?? '' ?>">
                    <input type="number" step="0.01" name="quadril" placeholder="Quadril" required value="<?= $editar_dados['quadril'] ?? '' ?>">
                    <input type="number" step="0.01" name="peito" placeholder="Peito" required value="<?= $editar_dados['peito'] ?? '' ?>">
                </div>
                <div class="form-row">
                    <input type="number" step="0.01" name="braco_d" placeholder="Braço D" required value="<?= $editar_dados['braco_d'] ?? '' ?>">
                    <input type="number" step="0.01" name="braco_e" placeholder="Braço E" required value="<?= $editar_dados['braco_e'] ?? '' ?>">
                    <input type="number" step="0.01" name="perna_d" placeholder="Perna D" required value="<?= $editar_dados['perna_d'] ?? '' ?>">
                    <input type="number" step="0.01" name="perna_e" placeholder="Perna E" required value="<?= $editar_dados['perna_e'] ?? '' ?>">
                    <input type="number" step="0.01" name="panturrilha_d" placeholder="Pant D" required value="<?= $editar_dados['panturrilha_d'] ?? '' ?>">
                    <input type="number" step="0.01" name="panturrilha_e" placeholder="Pant E" required value="<?= $editar_dados['panturrilha_e'] ?? '' ?>">
                    <button type="submit"><?= $editar_dados ? 'Atualizar' : 'Salvar' ?></button>
                </div>
            </form>
        </div>

        <div class="box">
            <h2>Suas Medidas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Data</th><th>Peso</th><th>Altura</th><th>Ombro</th><th>Abdômen</th>
                        <th>Quadril</th><th>Peito</th><th>Braço D</th><th>Braço E</th>
                        <th>Perna D</th><th>Perna E</th><th>Pant D</th><th>Pant E</th>
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
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="editar_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="edit">Editar</button>
                            </form>
                            <form method="post" action="php/apagar_medida.php" onsubmit="return confirm('Deseja realmente apagar?');" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="delete">X</button>
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