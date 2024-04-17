<?php

class MeuPokemon
{
    private $pokemon = null;

    public function __set($attr, $valor)
    {
        $this->$attr = $valor;
    }

    public function __get($attr)
    {
        return $this->$attr;
    }

    private function ExibirSprite($data)
    {

        $spriteUrl = $data['sprites']['other']['official-artwork'];
        if (isset($spriteUrl)) {
            $official_artwork = $spriteUrl;
            if (isset($official_artwork['front_default'])) {
                echo "<img style='width: 150px; height: 150px;' src='{$official_artwork['front_default']}' alt='{$this->pokemon} official-artwork default'>";
            }
            if (isset($official_artwork['front_shiny'])) {
                echo "<img style='width: 150px; height: 150px;' src='{$official_artwork['front_shiny']}' alt='{$this->pokemon} official-artwork shiny'>";
            }
        }
    }

    private function ExibirAltura($data)
    {

        $altura = (float) $data['height'] / 10;
        echo $altura;
    }
    private function ExibirStatus($data)
    {
        foreach ($data['stats'] as $status) {
            $nomeStatus = ucfirst(str_replace('-', ' ', $status['stat']['name'])); // Converte o nome do status para a forma correta
            $baseStat = $status['base_stat'];
            echo "$nomeStatus: $baseStat<br>";
        }
    }
    private function ObterHabilidades($data)
    {

        foreach ($data['abilities'] as $ability) {
            echo $ability['ability']['name'] . ": " . $ability['is_hidden'] ? "(oculta)" : "" . "<br>";
        }
    }



    private function ExibirChoros($data)
    {

        echo "Latest: " . $data['latest'] . "<br>";
        echo "Legacy: " . $data['legacy'] . "<br>";
        echo "Formas: " . $data['forms'][0]['name'] . "<br>";
    }

    private function ExibirJogos($data)
    {
        echo "<h2>Jogos em que aparece:</h2>";
        foreach ($data['game_indices'] as $game) {
            echo $game['version']['name'] . "<br>";
        }
    }




    private function ExibirMovimentos($data)
    {

        foreach ($data['moves'] as $move) {
            echo $move['move']['name'] . ": " . $move['version_group_details'][0]['move_learn_method']['name'] . "<br>";
        }
    }



    private function ExibirLocalizacaoEncontros($data)
    {

        echo "<a href='" . $data['location_area_encounters'] . "'>Link para a localização de encontros</a>";
    }

    public function PegarPokemon($poke, $infoParaExibir)
    {
        // Necessário a conversão da string para lowercase, pois a API não aceita string em caixa alta
        $poke = strtolower($poke);

        try {
            // URL da API que você deseja acessar
            $url = "https://pokeapi.co/api/v2/pokemon/$poke";

            // Faz a requisição e obtém a resposta
            $response = file_get_contents($url);

            // Decodifica o JSON em um array associativo
            $data = json_decode($response, true);

            // Verifica se a decodificação foi bem-sucedida
            if ($data === null) {
                throw new Exception('Erro ao decodificar JSON');
            }

            // Recebe o parametro de qual método utilizar
            foreach ($infoParaExibir as $info) {
                if (method_exists($this, $info)) {
                    $this->$info($data);
                } else {
                    throw new Exception('Esse método não existe ' . $info);
                }
            }
        } catch (Exception $e) {

            echo '<p style="color: red">' . $e->getMessage() . '</p>'; // Exibe a mensagem de erro da exceção
        }
    }
}
