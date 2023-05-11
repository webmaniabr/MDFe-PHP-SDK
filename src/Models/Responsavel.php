<?php

namespace Webmaniabr\Mdfe\Models;

use Webmaniabr\Mdfe\Enums\TipoResponsavel;

class Responsavel
{
    /**
     * Responsável pelo seguro.
     * @see TipoResponsavel
     * @var int
     */
    public int $tipoResponsavel;

    /**
     * Número do CPF. Não é necessário informar caso o responsável seja o emitente do MDF-e.
     * @var string
     */
    public string $cpf;

    /**
     * Número do CNPJ. Não é necessário informar caso o responsável seja o emitente do MDF-e.
     * @var string
     */
    public string $cnpj;
}