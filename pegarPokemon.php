<?php

require_once "classes/pokemons.php";

$pokemon = new MeuPokemon();

$pokemon->__set('pokemon', $_POST['pokemon']);




?>

<?php
require_once "include/header.php";


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Pokemon</title>
</head>

<body>
    <main>
        <div>
            <h1>Gotta Catch ’Em All!</h1>
            <h3>Voce encontrou o pokemon!! </h3>
            <h3><?= $pokemon->__get('pokemon') ?> </h3>
            <section>
                <?php $pokemon->PegarPokemon($pokemon->__get('pokemon'), ['ExibirSprite']); ?>
            </section>
            <section>
                <h3>Altura</h3>
                <p><?php $pokemon->PegarPokemon($pokemon->__get('pokemon'), ['ExibirAltura']); ?> metros</p>
            </section>
            <section>
                <h3>Status</h3>
                <?php $pokemon->PegarPokemon($pokemon->__get('pokemon'), ['ExibirStatus']); ?>
            </section>
        </div>
    </main>


    <?php
    require_once "include/footer.php";
    ?>
</body>

</html>