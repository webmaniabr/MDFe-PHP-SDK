<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Rodoviario;

use Webmaniabr\Mdfe\Enums\TipoProprietario;
use Webmaniabr\Mdfe\Enums\UF;

class Proprietario
{
    /**
     * 	Número do CPF.
     * @var string
     */
    public string $cpf;

    /**
     * Número do CNPJ.
     * @var string
     */
    public string $cnpj;

    /**
     * Nome completo.
     * @var string
     */
    public string $nomeCompleto;

    /**
     * Razão Social.
     * @var string
     */
    public string $razaoSocial;

    /**
     * Inscrição Estadual.
     * @var string
     */
    public string $ie;

    /**
     * RNTRC do proprietário.
     * @var string
     */
    public string $rntrc;

    /**
     * Siglado Uf do proprietário.
     * @see UF
     * @var string
     */
    public string $uf;

    /**
     * Tipo do proprietário
     * @see TipoProprietario
     * @var string
     */
    public string $tipoProprietario;
}