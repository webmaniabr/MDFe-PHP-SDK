<?php

namespace Webmaniabr\Mdfe\Models;

use Webmaniabr\Mdfe\Enums\TipoUnidadeCarga;

class UnidadeCarga
{
    /**
     * Tipo da Unidade de Carga.
     * @see TipoUnidadeCarga
     * @var int
     */
    public int $tipo;

    /**
     * Identificação da Unidade de Carga. Informar a identificação da unidade de carga, por exemplo: número do container.
     * @var string
     */
    public string $identificacao;

    /**
     * Lacres das Unidades de Carga.
     * @var string[]
     */
    public array $lacres = [];

    /**
     * Quantidade rateada (Peso,Volume).
     * @var float
     */
    public float $quantidadeRateada;

    /**
     * Adiciona novo lacre.
     * @param string $lacre
     */
    public function newLacre(string $lacre)
    {
        $this->lacres[] = $lacre;
    }
}