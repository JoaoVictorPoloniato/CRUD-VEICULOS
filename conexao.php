<?php

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "cadastroveiculos";

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando erros de conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
