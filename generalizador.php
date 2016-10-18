<?php

setlocale(LC_CTYPE, 'es_AR.UTF8');

function read_table($name,&$table){
    $full_table = file_get_contents($name);
    $nombres = explode("\n", $full_table);
    foreach($nombres as $nombre){
        $table[mb_strtoupper($nombre)] = 1;
    }
}

if($_POST['text']){
    header("Content-Type: text/plain");

    // leer tablas

    $male = array();
    read_table("wiki-male.names",$male);
    read_table("wiki-male.names,ascii",$male);
    $female = array();
    read_table("wiki-female.names",$female);
    read_table("wiki-female.names,ascii",$female);
    
    // determino genero
    $nombres_totales = explode("\n", $_POST['text']);

    foreach($nombres_totales as $nombre_total){
        $nombre_total = trim($nombre_total);
        $nombres = explode(" ", $nombre_total);
        $primer_nombre = $nombres[0];
        if($_POST['apellido']){
            $primer_nombre = $nombres[1];
        }
        if(isset($male[$primer_nombre])){
            echo "$nombre_total,m\n";
        } elseif(isset($female[$primer_nombre])){
            echo "$nombre_total,f\n";
        } else {
            echo "$nombre_total\n";
        }
    }
}else{
?>
<html><head><title>Determinacion de genero a partir de nombres propios</title>
    <body>
    <h1>Determinacion de genero a partir de nombres propios</h1>

    
    <p>Ingrese un nombre por renglon:</p>
    <form method="post">
    <textarea name="text" cols=60 rows=20></textarea><br>
      Apellido primero? <input type="checkbox" name="apellido"><br>
      <input type="submit">
    </form>
</body>
</html>
<?php
}
?>