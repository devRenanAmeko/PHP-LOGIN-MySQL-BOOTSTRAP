<?php

//destroi a sessao
session_destroy();

//redireciona para a pagina inicial
header('Location: index.php?rota=home');