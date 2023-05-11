<?php

namespace Webmaniabr\Mdfe\Models\Modalidades;

use Webmaniabr\Mdfe\Interfaces\TransportMode;
use Webmaniabr\Mdfe\Models\Modalidades\Ferroviario\Trem;
use Webmaniabr\Mdfe\Models\Modalidades\Ferroviario\Vagao;

class Ferroviario implements TransportMode
{
    /**
     * Informações da composição do trem.
     * @var Trem
     */
    public Trem $Trem;

    /**
     * Informações dos vagões.
     * @var Vagao[]
     */
    public array $Vagoes;

    /**
     * Adiciona um novo vagão.
     * @param Vagao $Vagao
     */
    public function addVagao(Vagao $Vagao)
    {
        $this->Vagoes[] = $Vagao;
    }

    /**
     * Adiciona e retorna um novo vagão.
     * @return Vagao
     */
    public function newVagao()
    {
        $Vagao = new Vagao();
        $this->Vagoes[] = $Vagao;
        return $Vagao;
    }

    public function __construct()
    {
        $this->Trem = new Trem();
    }

    /**
     * {@inheritDoc}
     */
    public function getCode(): int
    {
        return 4;
    }
}