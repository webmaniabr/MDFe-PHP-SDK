<?php

namespace Webmaniabr\Mdfe\Models;

class Lotacao
{
    /**
     * CEP do Local de Carregamento/Descarregamento.
     * @var string
     */
    public string $cep;

    /**
     * Latitude do Local de Carregamento/Descarregamento.
     * @var string
     */
    public string $latitude;

    /**
     * Longitude do Local de Carregamento/Descarregamento.
     * @var string
     */
    public string $longitude;
}