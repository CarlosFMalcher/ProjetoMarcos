<?php
// Conectar ao banco de dados
$conn = new mysqli("localhost", "usuario", "senha", "nome_do_banco");

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para obter o histórico de pagamentos
function getHistoricoPagamentos($conn) {
    $sql = "SELECT data_pagamento, valor_pago, status, comprovante FROM pagamentos ORDER BY data_pagamento DESC";
    $result = $conn->query($sql);

    $pagamentos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pagamentos[] = $row;
        }
    }
    return $pagamentos;
}

// Lógica para o upload do comprovante
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['comprovante'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["comprovante"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar o tipo de arquivo
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "pdf") {
        echo "Apenas arquivos JPG, JPEG, PNG e PDF são permitidos.";
        $uploadOk = 0;
    }

    // Verificar se o arquivo foi carregado
    if ($uploadOk && move_uploaded_file($_FILES["comprovante"]["tmp_name"], $target_file)) {
        // Salvar o caminho do comprovante no banco de dados
        $data_pagamento = date('Y-m-d'); // Exemplo de data atual
        $valor_pago = $_POST['valor_pago']; // Receber valor do pagamento via formulário
        $status = "pago";

        $stmt = $conn->prepare("INSERT INTO pagamentos (data_pagamento, valor_pago, status, comprovante) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $data_pagamento, $valor_pago, $status, $target_file);
        $stmt->execute();
        $stmt->close();

        echo "Comprovante enviado com sucesso!";
    } else {
        echo "Erro ao enviar o comprovante.";
    }
}

// Obter histórico de pagamentos para exibir na tabela
$historicoPagamentos = getHistoricoPagamentos($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Funcionários</title>
    <!-- Estilos omitidos para concisão -->
</head>
<body>
    <div class="container">
        <h1>Histórico de Pagamentos</h1>
        <table>
            <thead>
                <tr>
                    <th>Data de Pagamento</th>
                    <th>Valor Pago</th>
                    <th>Status</th>
                    <th>Comprovante</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historicoPagamentos as $pagamento): ?>
                    <tr>
                        <td><?php echo $pagamento['data_pagamento']; ?></td>
                        <td><?php echo "R$ " . number_format($pagamento['valor_pago'], 2, ',', '.'); ?></td>
                        <td>
                            <span class="status <?php echo $pagamento['status'] == 'pago' ? 'pago' : ''; ?>">
                                <?php echo ucfirst($pagamento['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($pagamento['comprovante']): ?>
                                <a href="<?php echo $pagamento['comprovante']; ?>" target="_blank">Ver Comprovante</a>
                            <?php else: ?>
                                Não disponível
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulário de Upload -->
        <div class="upload-container">
            <h2>Upload de Comprovante de Pagamento</h2>
            <form action="tela_funcionarios.php" method="POST" enctype="multipart/form-data">
                <input type="number" name="valor_pago" placeholder="Valor do pagamento" required>
                <input type="file" name="comprovante" required>
                <button type="submit">Enviar Comprovante</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>