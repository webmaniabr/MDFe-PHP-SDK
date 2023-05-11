<?php

namespace Webmaniabr\Mdfe\Models;

class DocumentoFiscal
{
    /**
     * Chave de acesso.
     * @var string
     */
    public string $chave;

    /**
     * Segundo código de barras.
     * @var string
     */
    public string $codigoBarras;

    /**
     * Indicador de Reentrega
     * @var bool
     */
    public bool $indicadorReentrega;

    /**
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão).
     * @var UnidadeTransporte[]
     */
    public array $unidadesTransporte = [];

    /**
     * Informações de periculosidade da carga.
     * @var array
     */
    public array $periculosidades = [];

    /**
     * Cria e retorna uma nova unidade de transporte.
     * @return UnidadeTransporte
     */
    public function newUnidadeTransporte()
    {
        $unidadeTransporte = new UnidadeTransporte();
        $this->unidadesTransporte[] = $unidadeTransporte;
        return $unidadeTransporte;
    }

    /**
     * Adiciona uma nova unidade de transporte.
     * @param UnidadeTransporte $unidadeTransporte
     */
    public function addUnidadeTransporte(UnidadeTransporte $unidadeTransporte)
    {
        $this->unidadesTransporte[] = $unidadeTransporte;
    }


}