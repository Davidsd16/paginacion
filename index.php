<?php

try {
    $conexion = new PDO('mysql:host=localhost;dbname=paginacion', 'root', '');
}catch (PDOException $e) {
    echo "ERROR:" . $e->getMessage();
    die();
}

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$post_pagina = 5;

$inicio = ($pagina > 1) ? ($pagina * $post_pagina - $post_pagina) : 0;

$articulos = $conexion->prepare(
    "SELECT SQL_CALC_FOUND_ROWS * FROM 
    articulos LIMIT $inicio, $post_pagina"
    );

$articulos->execute();
$articulos = $articulos->fetchAll();

if(!$articulos) {
    header('Location: index.php');
}

$total_articulos = $conexion->query('SELECT FOUND_ROWS() as total');
$total_articulos = $total_articulos->fetchAll()[0]['total'];
$numero_paginas = ceil($total_articulos / $post_pagina);

require 'index_view.php';