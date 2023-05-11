<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Aquaviario;

use Webmaniabr\Mdfe\Enums\TipoUnidadeCarga;
use Webmaniabr\Mdfe\Enums\TipoUnidadeTransporte;

class UnidadeVazia
{
    /**
     * Identificação da unidade.
     * @var string
     */
    public string $identificador;

    /**
     * Tipo da unidade.
     * @see TipoUnidadeCarga
     * @see TipoUnidadeTransporte
     * @var string
     */
    public string $tipoUnidade;
}