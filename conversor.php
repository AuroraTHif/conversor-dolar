<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleconversor.css">
</head>
<body>
<header>
        <h1>Resultado:</h1>
    </header>


    <main> 
    
        <?php

            $inicio = date ("m-d-Y" , strtotime("-7 days"));
            $fim = date ("m-d-Y");
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dados = json_decode(file_get_contents($url), true);

            $escolha_usuario = $dados["value"][0]["cotacaoCompra"];

            $real = $_REQUEST["dinheiro"] ?? 0;

            $dolar = $real / $escolha_usuario;

            //Um formato simples de gerar o resultado(Sem biblioteca)
            //echo "seus R\$ " . number_format($real, 2, ",", ".") . " equivalem a US\$ " . number_format($dolar, 2, ",", "." ) ;

            $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
            
            //Biblioteca intl (internalization PHP)
            echo "<p>Seus " . numfmt_format_currency($padrao, $real, "BRL") . " equivalem a <strong>" . numfmt_format_currency($padrao, $dolar, "USD") . "</strong> </p>";
        ?>
        <br>
        <button onclick="javascript:history.go(-1)"> &#x1F504; Gerar outro resultado</button>
    </main>
    
</body>
</html>