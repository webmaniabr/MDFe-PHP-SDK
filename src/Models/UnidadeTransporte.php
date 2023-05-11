<?php

namespace Webmaniabr\Mdfe\Models;

use Webmaniabr\Mdfe\Enums\TipoUnidadeTransporte;

class UnidadeTransporte
{
    /**
     * Tipo da Unidade de Transporte
     * @see TipoUnidadeTransporte
     * @var int
     */
    public int $tipo;

    /** Identificação da Unidade de Transporte. Informar a identificação conforme o tipo de unidade de transporte. Por exemplo, para rodoviário tração ou reboque deverá informar a placa do veículo.
     * @var string
     */
    public string $identificacao;

    /**
     * Lacres das Unidades de Transporte.
     * @var string[]
     */
    public array $lacres = [];

    /**
     * Quantidade rateada (Peso,Volume).
     * @var string
     */
    public string $quantidadeRateada;

    /**
     * Informações das Unidades de Carga (Containeres/ULD/Outros).
     * @var UnidadeCarga[]
     */
    public array $unidadesCarga = [];

    /**
     * Adiciona novo lacre.
     * @param string $lacre
     */
    public function newLacre(string $lacre)
    {
        $this->lacres[] = $lacre;
    }

    /**
     * Adiciona e retorna uma unidade de carga.
     * @return UnidadeCarga
     */
    public function newUnidadeCarga(): UnidadeCarga
    {
        $unidadeCarga = new UnidadeCarga();
        $this->unidadesCarga[] = $unidadeCarga;
        return $unidadeCarga;
    }

    /**
     * Adiciona uma unidade de carga.
     * @param UnidadeCarga $unidadeCarga
     */
    public function addUnidadeCarga(UnidadeCarga $unidadeCarga)
    {
        $this->unidadesCarga[] = $unidadeCarga;
    }
}