<?php 
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'CheckCar');

$conn = new mysqli(HOST, USER, PASS, BASE);

// Verifica se houve erro
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
} else {
    // echo "Conexão bem-sucedida!";
}
?>