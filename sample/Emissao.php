<?php

require('../vendor/autoload.php');

\Webmaniabr\Mdfe\Api\Connection::getInstance()->setBearerToken('SEU_TOKEN_AUTENTICACAO');
$MDFe = new \Webmaniabr\Mdfe\Models\MDFe();
$MDFe->emitente = \Webmaniabr\Mdfe\Enums\TipoEmitente::PRESTADOR_DE_SERVICO;
$MDFe->transportador = \Webmaniabr\Mdfe\Enums\TipoTransportador::TAC;
$MDFe->ufCarregamento = \Webmaniabr\Mdfe\Enums\UF::GOIAS;
$MDFe->ufDescarregamento = \Webmaniabr\Mdfe\Enums\UF::PARANA;
$MDFe->valorCarga = 500;
$MDFe->unidade = \Webmaniabr\Mdfe\Enums\Unidade::KG;
$MDFe->pesoBruto = 50000;
$Carregamento = $MDFe->newCarregamento();
$Carregamento->codigoMunicipio = '5208707';
$Carregamento->nomeMunicipio = 'Goiânia';
$Descarregamento = $MDFe->newDescarregamento();
$Descarregamento->codigoMunicipio = '4106902';
$Descarregamento->nomeMunicipio = 'Curitiba';
$DocumentoFiscal = $Descarregamento->newDocumentoFiscal();
$DocumentoFiscal->chave = '00000000000000000000000000000000000000000000';
$MDFe->Percurso->GO()->MG()->SP()->PR();
$Rodoviario = $MDFe->Rodoviario();
$Rodoviario->rntrc = '12313';
$ValePedagio = $Rodoviario->newValePedagio();
$ValePedagio->valor = 40;
$MDFe->emitir();