<?php

require('../vendor/autoload.php');

\Webmaniabr\Mdfe\Api\Connection::getInstance()->setBearerToken('SEU_TOKEN_AUTENTICACAO');
$MDFe = new \Webmaniabr\Mdfe\Models\MDFe();
$MDFe->chave = '00000000000000000000000000000000000000000000';
$MDFe->cancelar('Erro de emissão');