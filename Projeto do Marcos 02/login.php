<?php
header('Content-Type: application/json');

// Simulando um banco de dados de funcionários
$funcionarios = [
    ['codigo' => '123', 'senha' => 'senha123'],
    ['codigo' => '456', 'senha' => 'senha456']
];

// Obtendo os dados recebidos do frontend
$data = json_decode(file_get_contents('php://input'), true);
$codigo = $data['codigo'];
$senha = $data['senha'];

// Função de validação de login
function validarLogin($codigo, $senha, $funcionarios) {
    foreach ($funcionarios as $funcionario) {
        if ($funcionario['codigo'] === $codigo && $funcionario['senha'] === $senha) {
            return true;
        }
    }
    return false;
}

$response = [];
if (validarLogin($codigo, $senha, $funcionarios)) {
    $response = ['success' => true];
} else {
    $response = ['success' => false];
}

echo json_encode($response);
?>