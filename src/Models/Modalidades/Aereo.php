<?php

namespace Webmaniabr\Mdfe\Models\Modalidades;

use Webmaniabr\Mdfe\Interfaces\TransportMode;

class Aereo implements TransportMode
{
    /**
     * Marca de nacionalidade da Aeronave.
     * @var string
     */
    public string $nacionalidadeAeronave;

    /**
     * Marca de matrícula da Aeronave.
     * @var string
     */
    public string $matriculaAeronave;

    /**
     * Número do Voo.
     * @var string
     */
    public string $numeroVoo;

    /**
     * Aeródromo de Embarque.
     * @var string
     */
    public string $aerodromoEmbarque;

    /**
     * Aeródromo de Destino.
     * @var string
     */
    public string $aerodromoDestino;

    /**
     * Data do Voo.
     * @var \DateTime
     */
    public \DateTime $dataVoo;

    /**
     * {@inheritDoc}
     */
    public function getCode(): int
    {
        return 2;
    }
}