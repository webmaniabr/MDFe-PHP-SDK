<?php

require('../vendor/autoload.php');

\Webmaniabr\Mdfe\Api\Connection::getInstance()->setBearerToken('SEU_TOKEN_AUTENTICACAO');
$MDFe = new \Webmaniabr\Mdfe\Models\MDFe();
$MDFe->chave = '00000000000000000000000000000000000000000000';
$Condutor = new \Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\Condutor();
$Condutor->nome = 'Fulano de Tal';
$Condutor->cpf = "000.000.000-00";
$MDFe->incluirCondutor($Condutor);