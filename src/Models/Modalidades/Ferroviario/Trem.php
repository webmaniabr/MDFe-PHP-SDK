<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Ferroviario;

class Trem
{
    /**
     * Prefixo do trem.
     * @var string
     */
    public string $prefixo;

    /**
     * Data e hora de liberação do trem na origem.
     * @var \DateTime
     */
    public \DateTime $dataLiberacao;

    /**
     * Sigla da estação de origem do trem.
     * @var string
     */
    public string $origem;

    /**
     * Sigla da estação de destino do trem.
     * @var string
     */
    public string $destino;
}