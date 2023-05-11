<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Ferroviario;

class Vagao
{
    /**
     * Peso Base de Cálculo de Frete em Toneladas.
     * @var string
     */
    public string $pesoBC;

    /**
     * Peso real em toneladas.
     * @var string
     */
    public string $pesoReal;

    /**
     * Tipo de vagão.
     * @var string
     */
    public string $tipoVagao;

    /**
     * Série de identificação.
     * @var string
     */
    public string $serie;

    /**
     * Número de identificação.
     * @var string
     */
    public string $numero;

    /**
     * Sequência da composição.
     * @var string
     */
    public string $sequenciaVagao;

    /**
     * Tonelada útil.
     * @var string
     */
    public string $toneladaUtil;
}