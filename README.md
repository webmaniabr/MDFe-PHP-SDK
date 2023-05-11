
<p align="center">
  <img src="https://wmbr.s3.amazonaws.com/img/logo_webmaniabr_github2.png">
</p>

# MDF-e PHP SDK
SDK de comunicação com API 2.0 da Webmania para MDF-e.
Através do emissor de Nota Fiscal de Serviço da Webmania®, você conta com a emissão e arquivamento das seus MDF-e, encerramento, cancelamento e impressão dos documentos. Realize a integração do seu sistema com esta SDK para o MDF-e.

- Emissor de Nota Fiscal Webmania®: [Saiba mais](https://webmaniabr.com/nota-fiscal-eletronica/)
- Documentação REST API: [Visualizar](https://webmaniabr.com/docs/rest-api-mdfe/)

## Requisitos

- Contrate um dos planos de MDF-e da Webmania® para obter suas credenciais de acesso: [Conheça os Planos (Teste 30 dias grátis!)](https://webmaniabr.com/nota-fiscal-eletronica/#plans-section).
- Obtenha o [Composer](https://getcomposer.org/) e instale o pacote da SDK e suas dependências.

## Endpoints

A SDK possui os recursos necessários para utilizar os endpoints de Emissão, Consulta, Encerramento, Cancelamento e Inclusão de Condutor para o MDF-e.

## Utilização
Instale o módulo da Webmania® via composer ou baixe nosso repositório e utilize as classes de emissão mencionadas mais abaixo:

```php
composer require webmaniabr/mdfe
```

Após executar o composer, adicione o require no topo do seu arquivo, dessa forma as classes da SDK serão carregadas automaticamente.

```php
require_once __DIR__ . '/vendor/autoload.php';
```

Para emissão, deve ser usada a classe MDFe

```php
\Webmaniabr\Mdfe\Api\Connection::getInstance()->setBearerToken('SEU_TOKEN_AUTENTICACAO');
$MDFe = new \Webmaniabr\Mdfe\Models\MDFe();
$MDFe->emitente = \Webmaniabr\Mdfe\Enums\TipoEmitente::PRESTADOR_DE_SERVICO;
$MDFe->transportador = \Webmaniabr\Mdfe\Enums\TipoTransportador::TAC;
$MDFe->ufCarregamento = \Webmaniabr\Mdfe\Enums\UF::GOIAS;
$MDFe->ufDescarregamento = \Webmaniabr\Mdfe\Enums\UF::PARANA;
$MDFe->valorCarga = 500;
...
echo $MDFe->emitir()->getMessage();
```

## Suporte

Qualquer dúvida entre em contato na nossa [Central de Ajuda](https://ajuda.webmaniabr.com) ou acesse o [Painel de Controle](https://webmaniabr.com/painel/) para conversar em tempo real no Chat ou Abrir um chamado.