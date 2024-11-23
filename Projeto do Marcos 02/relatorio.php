<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Relatórios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("imagen.6.jpg");
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }

        .status {
            font-weight: bold;
            color: #f44336;
        }

        .status.pago {
            color: #4CAF50;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        select, input[type="date"] {
            padding: 8px;
            margin: 5px;
            font-size: 16px;
        }

        .logo-container {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .logo-container img {
            width: 150px;
        }
    </style>
</head>
<body>

<div class="logo-container">
    <img src="logo uirapuru (1).jpg" alt="Logo">
</div>

<div class="container">
    <h1>Relatórios Quinzenais</h1>

    <!-- Filtros de Exibição -->
    <div class="filter-container">
        <select id="filterStatus">
            <option value="">Filtrar por Status de Pagamento</option>
            <option value="pago">Pago</option>
            <option value="não pago">Não Pago</option>
        </select>

        <input type="date" id="filterDate">

        <input type="text" id="filterName" placeholder="Filtrar por Nome do Funcionário" />
    </div>

    <!-- Exibição de Relatórios -->
    <table>
        <thead>
            <tr>
                <th>Nome do Funcionário</th>
                <th>Status de Pagamento</th>
                <th>Data de Pagamento</th>
                <th>Comprovante</th>
                <th>Atraso</th>
            </tr>
        </thead>
        <tbody id="reportTable">
            <!-- Dados de relatórios serão inseridos aqui -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Dados fictícios de pagamentos
        const reportData = [
            { nome: "João Silva", status: "pago", data: "2024-10-15", comprovante: "comprovante1.jpg", atraso: "" },
            { nome: "Maria Souza", status: "não pago", data: "2024-09-30", comprovante: "comprovante2.jpg", atraso: "Pagamento atrasado. Não pode ser pago por motivo de férias." },
            { nome: "Carlos Pereira", status: "pago", data: "2024-10-01", comprovante: "comprovante3.jpg", atraso: "" },
            { nome: "Ana Oliveira", status: "não pago", data: "2024-09-15", comprovante: "", atraso: "Atraso devido à falta de documentos." }
        ];

        // Função para atualizar o relatório
        function updateReportTable(data) {
            const reportTable = document.getElementById("reportTable");
            reportTable.innerHTML = ""; // Limpa a tabela antes de atualizar

            data.forEach(report => {
                const row = document.createElement("tr");

                // Nome do funcionário
                const nameCell = document.createElement("td");
                nameCell.textContent = report.nome;

                // Status de pagamento
                const statusCell = document.createElement("td");
                const statusText = document.createElement("span");
                statusText.textContent = report.status.charAt(0).toUpperCase() + report.status.slice(1);
                statusText.classList.add("status");
                if (report.status === "pago") {
                    statusText.classList.add("pago");
                }
                statusCell.appendChild(statusText);

                // Data de pagamento
                const dateCell = document.createElement("td");
                dateCell.textContent = report.data;

                // Comprovante
                const proofCell = document.createElement("td");
                if (report.comprovante) {
                    const proofLink = document.createElement("a");
                    proofLink.href = report.comprovante;
                    proofLink.textContent = "Ver Comprovante";
                    proofLink.target = "_blank";
                    proofCell.appendChild(proofLink);
                } else {
                    proofCell.textContent = "Não anexado";
                }

                // Atraso
                const delayCell = document.createElement("td");
                delayCell.textContent = report.atraso || "Nenhum atraso";

                row.appendChild(nameCell);
                row.appendChild(statusCell);
                row.appendChild(dateCell);
                row.appendChild(proofCell);
                row.appendChild(delayCell);

                reportTable.appendChild(row);
            });
        }

        // Função para filtrar os relatórios
        function filterReports() {
            const statusFilter = document.getElementById("filterStatus").value.toLowerCase();
            const dateFilter = document.getElementById("filterDate").value;
            const nameFilter = document.getElementById("filterName").value.toLowerCase();

            const filteredData = reportData.filter(report => {
                let matchesStatus = true;
                let matchesDate = true;
                let matchesName = true;

                if (statusFilter) {
                    matchesStatus = report.status.toLowerCase().includes(statusFilter);
                }

                if (dateFilter) {
                    matchesDate = report.data === dateFilter;
                }

                if (nameFilter) {
                    matchesName = report.nome.toLowerCase().includes(nameFilter);
                }

                return matchesStatus && matchesDate && matchesName;
            });

            updateReportTable(filteredData);
        }

        // Adiciona eventos de filtro
        document.getElementById("filterStatus").addEventListener("change", filterReports);
        document.getElementById("filterDate").addEventListener("change", filterReports);
        document.getElementById("filterName").addEventListener("input", filterReports);

        // Atualiza a tabela inicialmente com todos os dados
        updateReportTable(reportData);
    });
</script>

</body>
</html>