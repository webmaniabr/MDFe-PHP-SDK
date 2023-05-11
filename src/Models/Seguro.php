<?php

namespace Webmaniabr\Mdfe\Models;

class Seguro
{
    /**
     * Informações do responsável pelo seguro da carga.
     * @var Responsavel
     */
    public Responsavel $Responsavel;

    /**
     * Informações da seguradora.
     * @var Seguradora
     */
    public Seguradora $Seguradora;

    /**
     * Número da Apólice.
     * @var string
     */
    public string $numeroApolice;

    /**
     * Números das Averbações.
     * @var int[]
     */
    public array $numerosAverbacoes = [];

    public function __construct()
    {
        $this->Seguradora  = new Seguradora();
        $this->Responsavel = new Responsavel();
    }
}