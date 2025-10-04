<?php
$servername = getenv("DB_HOST") ?: 'mysql';
$username   = getenv("DB_USER");
$dbname     = getenv("DB_NAME");

$passwordFile = getenv("DB_PASS_FILE");
$password = $passwordFile && file_exists($passwordFile)
    ? trim(file_get_contents($passwordFile))
    : "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM personas");

echo "<h1>Lista de Personas</h1>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Nombre</th><th>Edad</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['edad']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros.";
}
$conn->close();
?>

