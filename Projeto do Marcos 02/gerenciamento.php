<?php
// Conectar ao banco de dados
$servername = "localhost"; // Alterar conforme necessário
$username = "root";        // Alterar conforme necessário
$password = "";            // Alterar conforme necessário
$dbname = "gerenciamento"; // Alterar conforme necessário

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Adicionar funcionário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_employee'])) {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $hireDate = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];

    $sql = "INSERT INTO employees (name, position, hire_date, salary, status)
            VALUES ('$name', '$position', '$hireDate', '$salary', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo funcionário adicionado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Editar funcionário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_employee'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $hireDate = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];

    $sql = "UPDATE employees SET name='$name', position='$position', hire_date='$hireDate', salary='$salary', status='$status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Funcionário atualizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Excluir funcionário
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM employees WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Funcionário excluído com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Buscar dados de funcionários
$employees = [];
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela do Administrador</title>
    <style>
        /* Estilos semelhantes aos fornecidos anteriormente */
    </style>
</head>
<body>

<div class="header">
    <h1>Gerenciamento de Funcionários</h1>
</div>

<div class="container">
    <button class="button" id="addEmployeeBtn">Cadastrar Novo Funcionário</button>
    <button class="button" id="generateReportBtn">Gerar Relatórios Quinzenais</button>
    <button class="button" id="generatePDFBtn">Exportar Relatório em PDF</button>

    <h2>Lista de Funcionários</h2>
    <table id="employeeTable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Data de Contratação</th>
                <th>Valor Quinzenal</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo $employee['name']; ?></td>
                    <td><?php echo $employee['position']; ?></td>
                    <td><?php echo $employee['hire_date']; ?></td>
                    <td><?php echo $employee['salary']; ?></td>
                    <td><?php echo $employee['status']; ?></td>
                    <td class="action-buttons">
                        <button class="button" onclick="editEmployee(<?php echo $employee['id']; ?>)">Editar</button>
                        <a href="?delete=<?php echo $employee['id']; ?>"><button class="button">Excluir</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Adding Employee -->
<div id="addEmployeeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
            <h3>Cadastrar Funcionário</h3>
        </div>
        <form id="addEmployeeForm" method="POST">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" required>

            <label for="position">Cargo:</label>
            <input type="text" name="position" id="position" required>

            <label for="hire_date">Data de Contratação:</label>
            <input type="date" name="hire_date" id="hire_date" required>

            <label for="salary">Valor Quinzenal:</label>
            <input type="number" name="salary" id="salary" required>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>

            <button type="submit" name="add_employee" class="button">Salvar</button>
        </form>
    </div>
</div>

<script>
    // Modal Script
    const addEmployeeBtn = document.getElementById("addEmployeeBtn");
    const addEmployeeModal = document.getElementById("addEmployeeModal");
    const closeModal = document.querySelector(".close");

    addEmployeeBtn.addEventListener("click", () => {
        addEmployeeModal.style.display = "flex";
    });

    closeModal.addEventListener("click", () => {
        addEmployeeModal.style.display = "none";
    });
</script>

</body>
</html>