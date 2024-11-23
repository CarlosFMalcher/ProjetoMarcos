-- Criando a tabela de Funcionários
CREATE TABLE Funcionarios (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome_Completo VARCHAR(255) NOT NULL,
    Cargo VARCHAR(255) NOT NULL,
    Codigo_de_Acesso VARCHAR(20) NOT NULL,
    Senha VARCHAR(255) NOT NULL,
    Data_de_Admissao DATE NOT NULL,
    Status ENUM('Ativo', 'Inativo') NOT NULL
);

-- Inserindo dados na tabela de Funcionários
INSERT INTO Funcionarios (Nome_Completo, Cargo, Codigo_de_Acesso, Senha, Data_de_Admissao, Status)
VALUES
    ('Ana Carolina Souza', 'Analista de TI', '001A', 'abcd1234', '2022-03-01', 'Ativo'),
    ('Bruno Pereira Costa', 'Coordenador de Vendas', '002B', 'efgh5678', '2021-06-15', 'Ativo'),
    ('Camila Oliveira Santos', 'Assistente de RH', '003C', 'ijkl9101', '2023-01-20', 'Inativo'),
    ('Diego Almeida Ribeiro', 'Gerente de Marketing', '004D', 'mnop1122', '2020-11-10', 'Ativo'),
    ('Fernanda Costa Lima', 'Analista Financeiro', '005E', 'qrst3345', '2022-09-05', 'Ativo');

-- Criando a tabela de Pagamentos
CREATE TABLE Pagamentos (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_Funcionario INT,
    Valor_do_Pagamento DECIMAL(10, 2) NOT NULL,
    Data_do_Pagamento DATE NOT NULL,
    Tipo ENUM('1ª Quinzena', '2ª Quinzena') NOT NULL,
    Status_do_Pagamento ENUM('Pago', 'Pendente') NOT NULL,
    FOREIGN KEY (ID_Funcionario) REFERENCES Funcionarios(ID)
);

-- Inserindo dados na tabela de Pagamentos
INSERT INTO Pagamentos (ID_Funcionario, Valor_do_Pagamento, Data_do_Pagamento, Tipo, Status_do_Pagamento)
VALUES
    (1, 2500.00, '2024-10-15', '1ª Quinzena', 'Pago'),
    (2, 3800.00, '2024-10-15', '2ª Quinzena', 'Pago'),
    (3, 1200.00, '2024-10-20', '1ª Quinzena', 'Pendente'),
    (4, 5000.00, '2024-10-10', '2ª Quinzena', 'Pago'),
    (5, 2700.00, '2024-10-05', '1ª Quinzena', 'Pago');

-- Criando a tabela de Comprovantes de Pagamento
CREATE TABLE Comprovantes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_Pagamento INT,
    Nome_do_Arquivo_do_Comprovante VARCHAR(255) NOT NULL,
    Caminho_do_Arquivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_Pagamento) REFERENCES Pagamentos(ID)
);

-- Inserindo dados na tabela de Comprovantes
INSERT INTO Comprovantes (ID_Pagamento, Nome_do_Arquivo_do_Comprovante, Caminho_do_Arquivo)
VALUES
    (1, 'comprovante_001A_15102024.pdf', '/comprovantes/001A_15102024.pdf'),
    (2, 'comprovante_002B_15102024.pdf', '/comprovantes/002B_15102024.pdf'),
    (3, 'comprovante_003C_20102024.pdf', '/comprovantes/003C_20102024.pdf'),
    (4, 'comprovante_004D_10102024.pdf', '/comprovantes/004D_10102024.pdf'),
    (5, 'comprovante_005E_05102024.pdf', '/comprovantes/005E_05102024.pdf');

-- Criando a tabela de Quinzenas
CREATE TABLE Quinzenas (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Data_Inicial DATE NOT NULL,
    Data_Final DATE NOT NULL,
    Numero_da_Quinzena INT NOT NULL
);

-- Inserindo dados na tabela de Quinzenas
INSERT INTO Quinzenas (Data_Inicial, Data_Final, Numero_da_Quinzena)
VALUES
    ('2024-10-01', '2024-10-15', 1),
    ('2024-10-16', '2024-10-31', 2),
    ('2024-09-01', '2024-09-15', 1),
    ('2024-09-16', '2024-09-30', 2),
    ('2024-08-01', '2024-08-15', 1);    