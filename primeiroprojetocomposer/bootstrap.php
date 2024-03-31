<?php

require __DIR__."/vendor/autoload.php";

$metodo = $_SERVER['REQUEST_METHOD'];
$caminho = $_SERVER['PATH_INFO'] ?? '/';

#use Php\Primeiroprojeto\Router dá na msm
$r = new Php\Primeiroprojeto\Router($metodo, $caminho);

#ROTAS

$r->get('/olamundo', function (){
    return "Olá mundo!";
} );

$r->get('/olapessoa/{nome}/', function($params){
    return 'Olá '.$params[1];
} );

$r->get('/soma/formulario', function(){
    include("soma.html");

});

$r->post('/soma/resposta', function(){
    $valor1 = $_POST['valor1'];
    $valor2 = $_POST['valor2'];
    $soma = $valor1 + $valor2;
    return "A soma é: {$soma}";
});

#exercícios

//ex1
$r->get('/lista2/ex1/{numero}', function($params){
    if($params[1]==0)
    {
        return 'O numero é 0';
    }
    if($params[1]>0)
    {
        return 'Numero positivo';
    }
    if($params[1]<0)
    {
        return 'Numero negativo';
    }
    return 'params[1]: '.$params[1];
});

//ex2
$r->get('/lista2/ex2/formulario', function(){
    include("ex2.html");
});

$r->post('/lista2/ex2/resposta', function(){
    $lista = array();
    $posicao = null;
    $menor = null;
    for($i=1;$i<=7;$i++)
    {
         $valor = $_POST['valor'.$i];
         array_push($lista, $valor);
         $menor = min($lista);
         if($valor == $menor)
         $posicao = $i; //era só usar um "array_search($menor,$lista);" que era muito mais fácil
    }

    return "O menor número é: {$menor} na posição {$posicao}";
});

//ex3
$r->get('/lista2/ex3/{numero1}/{numero2}', function($params){
    if($params[1]==$params[2])
    {
        return 'O triplo da soma desses números é: '.$params[1] * 6;
    }
    else
    return 'Números diferentes';
});

//ex4
$r->get('/lista2/ex4/{numero1}', function($params){
    $numero = $params[1];
    for($i=0; $i<=10; $i++)
    {
        $resultado = $numero * $i;
        echo $numero."x".$i."=".$resultado."<br>";
    }
});

//ex5
$r->get('/lista2/ex5/{numero}', function($params){
    $numero = $params[1];
    $contador = 1;
    for($i=1; $i<$numero; $i++)
    {
        $contador *= $i;
    }
    $resultado = $numero * $contador;
    return $numero."! = ".$resultado;

});

//ex6
$r->get('/lista2/ex6/{numero1}/{numero2}', function($params){
    $numero1 = $params[1];
    $numero2 = $params[2];
    $menor = null;
    if(is_numeric($numero1) && is_numeric($numero2))
    {
        if($numero1 < $numero2)
        {
            return $numero1." ". $numero2;
        }
        else if($numero1 > $numero2)
        {
            return $numero2." ". $numero1;
        }
        else
        {
            return "Números iguais: ".$numero1;
        }
    }
    else
    {
        return "Pelo menos um dos dois dados não é número";
    }
});

//ex7
$r->get('/lista2/ex7/{numero1}', function($params){
    $numero = $params[1];
    $cm = $numero * 100;
    return $cm."cm";
});

//ex8
$r->get('/lista2/ex8/{numero1}', function($params){
    $metro_quadrado = $params[1];
    $litro = $metro_quadrado / 3;
    $lata = $litro/18;
    $preco_total = $lata * 80;
    return "Precisa comprar ".$lata." latas de tintas, e o preço total é ".$preco_total;
});

//ex9
$r->get('/lista2/ex9/formulario', function(){
    include("ex9.html");
});

$r->post('/lista2/ex9/resposta', function(){
    $ano_nasc = $_POST["ano_nasc"];
    $nome = $_POST["nome"];
    $ano_atual = 2024;
    $idade = $ano_atual - $ano_nasc;
    $dias = $idade * 365;
    $idade_2025 = 2025 - $ano_nasc;
    return $nome." tem ".$idade." anos, viveu ". $dias. "dias e terá ". $idade_2025. "anos em 2025";
});

//ex10
$r->get('/lista2/ex10/formulario', function(){
    include("ex10.html");
});

$r->post('/lista2/ex10/resposta', function(){
    $peso = $_POST["peso"];
    $altura = $_POST["altura"];
    $imc = $peso/($altura)**2;
    if($imc<18.5)
    {
        return "<p>Está abaixo do normal. IMC=". $imc. "</p> <p> Para saber mais: <a href='https://www.programasaudefacil.com.br/calculadora-de-imc'>https://www.programasaudefacil.com.br/calculadora-de-imc</a></p>";
    }
    if($imc>=18.5 && $imc<25)
    {
        return "<p>Está na faixa do normal. IMC=". $imc. "</p> <p> Para saber mais: <a href='https://www.programasaudefacil.com.br/calculadora-de-imc'>https://www.programasaudefacil.com.br/calculadora-de-imc</a></p>";
    }
    if($imc>25)
    {
        return "<p>Está acima do normal. IMC=". $imc. "</p> <p> Para saber mais: <a href='https://www.programasaudefacil.com.br/calculadora-de-imc'>https://www.programasaudefacil.com.br/calculadora-de-imc</a></p>";
    }
});


#ROTAS

$resultado = $r->handler();

if(!$resultado){
    http_response_code(404);
    echo "Página não encontrada!";
    die();
}

echo $resultado($r->getParams());


