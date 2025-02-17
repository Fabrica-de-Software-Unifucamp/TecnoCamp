<?php
require 'db.php';

$query = $pdo->query("SELECT * FROM usuarios");
$users = $query->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Usuários cadastrados:</h3>";
echo "<pre>" . print_r($users, true) . "</pre>";
?>









