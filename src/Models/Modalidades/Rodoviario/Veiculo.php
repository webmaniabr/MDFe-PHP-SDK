<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Rodoviario;

use Webmaniabr\Mdfe\Enums\TipoCarroceria;
use Webmaniabr\Mdfe\Enums\TipoRodado;
use Webmaniabr\Mdfe\Enums\UF;

class Veiculo
{
    /**
     * Código interno do veículo.
     * @var string
     */
    public string $codigoInterno;

    /**
     * Placa do veículo.
     * @var string
     */
    public string $placa;

    /**
     * RENAVAM do veículo.
     * @var string
     */
    public string $renavam;

    /**
     * Tara em KG.
     * @var string
     */
    public string $tara;

    /**
     * 	Capacidade em KG do veículo. Obrigatório para veículo de reboque.
     * @var string
     */
    public string $capacidadeKg;

    /**
     * Capacidade em m3 do veículo.
     * @var string
     */
    public string $capacidadeM3;

    /**
     * Tipo de rodado.
     * @see TipoRodado
     * @var string
     */
    public string $tipoRodado;

    /**
     * Tipo de Carroceria.
     * @see TipoCarroceria
     * @var string
     */
    public string $tipoCarroceria;

    /**
     * Sigla da UF de Licenciamento do veículo.
     * @see UF
     * @var string
     */
    public string $ufLicenciamento;

    /**
     * Proprietário do veículo.
     * @var Proprietario
     */
    public Proprietario $Proprietario;

    public function __construct()
    {
        $this->Proprietario = new Proprietario();
    }
}