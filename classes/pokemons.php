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

    private function ExibirTipo($data)
    {

        foreach ($data['types'] as $tipo) {
            $nomeTipo = ucfirst($tipo['type']['name']);
            $urlTipo = $tipo['type']['url'];

            echo $nomeTipo;
        }
    }

    private function ExibirAltura($data)
    {

        $altura = (float) $data['height'] / 10;
        echo $altura;
    }

    private function ExibirPeso($data)
    {

        $peso = (float) $data['weight'] / 10;
        echo $peso;
    }
    private function ExibirStatus($data)
    {
        foreach ($data['stats'] as $status) {
            $nomeStatus = ucfirst(str_replace('-', ' ', $status['stat']['name'])); // Converte o nome do status para a forma correta
            $baseStat = $status['base_stat'];
            echo "$nomeStatus: $baseStat<br>";
        }
    }
    private function ExibirHabilidades($data)
    {

        foreach ($data['abilities'] as $ability) {
            echo ucfirst($ability['ability']['name'] . ($ability['is_hidden'] ? ' (Habilidade Oculta)' : '') . '<br/>');
        }
    }

    private function ExibirGritos($data)
    {
        foreach ($data['forms'] as $form) {

            echo '<audio controls>';
            echo '<source src="' . $data['cries']['latest'] . '" type="audio/ogg">';
            echo 'Seu navegador não suporta áudio HTML5.';
            echo '</audio><br>';
        }
    }

    private function ExibirJogos($data)
    {
        echo "<h2>Jogos em que aparece:</h2>";
        foreach ($data['game_indices'] as $game) {
            echo $game['version']['name'] . "<br>";
        }
    }




    // private function ExibirEvolucoes($data)
    // {
    //     // Verifica se a URL da cadeia de evolução está definida
    //     if (isset($data['species']['url'])) {
    //         // Obtém a URL da cadeia de evolução
    //         $evolution_chain_url = $data['species']['url'];

    //         // Faz uma solicitação HTTP para obter os detalhes da cadeia de evolução
    //         $evolution_chain_data = file_get_contents($evolution_chain_url);
    //         $evolution_chain_data = json_decode($evolution_chain_data, true);

    //         // Verifica se os dados da cadeia de evolução foram obtidos com sucesso
    //         if ($evolution_chain_data !== null) {
    //             // Obtém a URL específica da cadeia de evolução
    //             $evolution_chain_url = $evolution_chain_data['evolution_chain']['url'];

    //             // Faz uma solicitação HTTP para obter os detalhes específicos da cadeia de evolução
    //             $evolution_chain_details = file_get_contents($evolution_chain_url);
    //             $evolution_chain_details = json_decode($evolution_chain_details, true);

    //             // Verifica se os detalhes da cadeia de evolução foram obtidos com sucesso
    //             if ($evolution_chain_details !== null) {
    //                 // Itera sobre as etapas de evolução
    //                 $current_stage = $evolution_chain_details['chain'];
    //                 while ($current_stage) {
    //                     // Exibe o nome da espécie atual
    //                     echo "Nome da espécie: " . $current_stage['species']['name'] . "<br>";


    //                     // Verifica se existem evoluções para esta etapa
    //                     if (!empty($current_stage['evolves_to'])) {
    //                         // Se houver, avança para a próxima etapa de evolução
    //                         $current_stage = $current_stage['evolves_to'][0];
    //                     } else {
    //                         // Se não houver, encerra o loop
    //                         break;
    //                     }
    //                 }
    //             } else {
    //                 // Se houve um problema ao obter os detalhes da cadeia de evolução
    //                 echo "Erro ao obter os detalhes da cadeia de evolução.";
    //             }
    //         } else {
    //             // Se houve um problema ao obter os dados da cadeia de evolução
    //             echo "Erro ao obter os dados da cadeia de evolução.";
    //         }
    //     } else {
    //         // Se a URL da cadeia de evolução não estiver definida
    //         echo "URL da cadeia de evolução não encontrada.";
    //     }
    // }





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
