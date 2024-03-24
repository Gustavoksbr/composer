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

$r->get('/lista2/ex1/{numero}/', function($params){
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

$r->get('/lista2/exer2/formulario', function(){
    include("exer2.html");
});

$r->post('/lista2/exer2/resposta', function(){
    $valor1 = $_POST['valor1'];
    $valor2 = $_POST['valor2'];
    $valor3 = $_POST['valor3'];
    $valor4 = $_POST['valor4'];
    $valor5 = $_POST['valor5'];
    $valor6 = $_POST['valor6'];
    $valor7 = $_POST['valor7'];
    $lista = array();
    array_push($lista, $valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7);
    $menor = min($lista);

    return "O menor número é: {$menor}";
});


#ROTAS

$resultado = $r->handler();

if(!$resultado){
    http_response_code(404);
    echo "Página não encontrada!";
    die();
}

echo $resultado($r->getParams());


