<?php

namespace Webmaniabr\Mdfe\Models;

class Periculosidade
{
    /**
     * Número ONU/UN.
     * @var string
     */
    public string $numeroOnu;

    /**
     * Quantidade total por produto.
     * @var int
     */
    public int $quantidadeTotal;

    /**
     * Nome apropriado para embarque do produto.
     * @var string
     */
    public string $nomeEmbarque;

    /**
     * Classe ou subclasse/divisão, e risco subsidiário/risco secundário.
     * @var string
     */
    public string $classeRisco;

    /**
     * Grupo de Embalagem.
     * @var string
     */
    public string $grupoEmbalagem;

    /**
     * Quantidade e Tipo de volumes.
     * @var string
     */
    public string $quantidadeVolumes;

    /**
     * Informações da Entrega Parcial
     * @var EntregaParcial
     */
    public EntregaParcial $EntregaParcial;

    public function __construct()
    {
        $this->EntregaParcial = new EntregaParcial();
    }
}