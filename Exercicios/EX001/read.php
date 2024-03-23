<?php

// Conexão com o banco de dados MySQL
$servername = "sql.freedb.tech";
$username = "freedb_tauser";
$password = "dR*HEZn&G9&Jkm!";
$database = "freedb_tadelivery";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obter os dados dos usuários
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Verifica se existem dados de usuários
if ($result->num_rows > 0) {
    // Array para armazenar os dados dos usuários com suas respectivas notas
    $userDataWithNotes = array();

    // Loop através dos resultados dos usuários
    while($userRow = $result->fetch_assoc()) {
        // Obtém o ID do usuário
        $userID = $userRow['id'];

        // Consulta SQL para obter as notas do usuário atual
        $notesSql = "SELECT nota FROM notas_$userID";
        $notesResult = $conn->query($notesSql);

        // Array para armazenar as notas do usuário atual
        $userNotes = array();

        // Loop através dos resultados das notas e armazena no array
        while ($noteRow = $notesResult->fetch_assoc()) {
            $userNotes[] = $noteRow['nota'];
        }

        // Adiciona os dados do usuário com suas notas ao array principal
        $userRow['notas'] = $userNotes;
        $userDataWithNotes[] = $userRow;
    }

    // Retorna os dados dos usuários com suas notas como JSON
    echo json_encode($userDataWithNotes);
} else {
    echo "0 results";
}

$conn->close();
?>
