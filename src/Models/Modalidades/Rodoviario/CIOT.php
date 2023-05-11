<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Rodoviario;

class CIOT
{
    /**
     * Código CIOT.
     * @var string
     */
    public string $codigoCiot;

    /**
     * Número do CPF do Responsável pela geração do CIOT.
     * @var string
     */
    public string $cpfResponsavel;

    /**
     * Número do CNPJ do Responsável pela geração do CIOT.
     * @var string
     */
    public string $cnpjResponsavel;
}