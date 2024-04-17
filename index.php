<?php
require_once "include/header.php";


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Inicio</title>
</head>

<body>
    <main>
        <form action="pegarPokemon.php" method="post">
            <input type="search" name="pokemon" />

            <button type="submit">Pesquisar</button>
        </form>
    </main>


    <?php
    require_once "include/footer.php";
    ?>
</body>

</html>