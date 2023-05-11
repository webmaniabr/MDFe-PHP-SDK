<?php

namespace Webmaniabr\Mdfe\Interfaces;

interface TransportMode
{
    /**
     * Retorna o código da modalidade.
     * @return int
     */
    public function getCode() : int;
}