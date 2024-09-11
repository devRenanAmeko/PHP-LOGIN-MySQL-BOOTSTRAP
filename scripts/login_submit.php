<?php

//verifica se aconteceu um post
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php?rota=login');
    exit;
}

//busca os dados do post
$usuario = $_POST['text_usuario'] ?? null;
$senha = $_POST['text_senha'] ?? null;

//verifica se dados estao preenchidos
if(empty($usuario) || empty($senha)){
    header('Location: index.php?rota=login');
    exit;
}

//a class da base de dados ja esta carregada no index.php
$db = new database();
$params = [
    ':usuario' => $usuario
];
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$result = $db->query($sql, $params);

//verifica se aconteceu um erro
if($result['status'] === 'error'){
    header('Location: index.php?rota=404');
}

//verifica se usuario existe 
if(count($result['data']) === 0){

    //erro na sessao
    $_SESSION['error'] = 'usuario ou senha invalidos';

    header('Location: index.php?rota=login');
    exit;
}

//verifica se usuario existe
if(!password_verify($senha,$result['data'][0]->senha)){

    //erro na sessao
    $_SESSION['error'] = 'usuario ou senha invalidos';

    header('Location: index.php?rota=login');
    exit;
}

//define a sessao do usuario
$_SESSION['usuario'] = $result['data'][0];

//redirecionar para a pagina inicial
header('Location: index.php?rota=home');