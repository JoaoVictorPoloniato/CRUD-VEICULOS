<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "cadastroveiculos";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Configura o cabeçalho para permitir o acesso CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// Verifica a ação a ser executada
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Executa a ação correspondente
    switch ($action) {
        case 'create':
            createVeiculo();
            break;
        case 'read':
            readVeiculos();
            break;
        case 'update':
            updateVeiculo();
            break;
        case 'delete':
            deleteVeiculo();
            break;
        case 'getById':
            getVeiculoById();
            break;
        default:
            echo "Ação inválida";
    }
}

// Função para criar um novo veículo
function createVeiculo()
{
    global $conn;

    // Obtém os dados do formulário
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];
    $cor = $_POST['cor'];
    $tipo_de_veiculo = $_POST['tipo_de_veiculo'];
    $renavam = $_POST['renavam'];

    // Insere os dados no banco de dados
    $sql = "INSERT INTO veiculos (marca, modelo, ano, placa, cor, tipo_de_veiculo, renavam)
            VALUES ('$marca', '$modelo', $ano, '$placa', '$cor', '$tipo_de_veiculo', '$renavam')";

    if ($conn->query($sql) === TRUE) {
        echo "Veículo adicionado com sucesso";
    } else {
        echo "Erro ao adicionar veículo: " . $conn->error;
    }
}

// Função para ler os veículos do banco de dados
function readVeiculos()
{
    global $conn;

    // Seleciona todos os veículos
    $sql = "SELECT * FROM veiculos order by id asc";
    $result = $conn->query($sql);

    $veiculos = array();

    // Obtém os dados dos veículos
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $veiculos[] = $row;
        }
    }

    // Retorna os veículos como JSON
    echo json_encode($veiculos);
}

// Função para atualizar um veículo
function updateVeiculo()
{
    global $conn;

    // Obtém os dados do formulário
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];
    $cor = $_POST['cor'];
    $tipo_de_veiculo = $_POST['tipo_de_veiculo'];
    $renavam = $_POST['renavam'];

    // Atualiza os dados no banco de dados
    $sql = "UPDATE veiculos SET marca = '$marca', modelo = '$modelo', ano = $ano,
            placa = '$placa', cor = '$cor', tipo_de_veiculo = '$tipo_de_veiculo', renavam = '$renavam'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Veículo atualizado com sucesso";
    } else {
        echo "Erro ao atualizar veículo: " . $conn->error;
    }
}

// Função para excluir um veículo
function deleteVeiculo()
{
    global $conn;

    // Obtém o ID do veículo a ser excluído
    $id = $_POST['id'];

    // Exclui o veículo do banco de dados
    $sql = "DELETE FROM veiculos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Veículo excluído com sucesso";
    } else {
        echo "Erro ao excluir veículo: " . $conn->error;
    }
}

// Função para obter um veículo pelo ID
function getVeiculoById()
{
    global $conn;

    // Obtém o ID do veículo a ser obtido
    $id = $_POST['id'];

    // Seleciona o veículo com base no ID
    $sql = "SELECT * FROM veiculos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $veiculo = $result->fetch_assoc();

        // Retorna o veículo como JSON
        echo json_encode($veiculo);
    } else {
        echo "Veículo não encontrado";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
