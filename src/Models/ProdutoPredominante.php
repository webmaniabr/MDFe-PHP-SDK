<?php

namespace Webmaniabr\Mdfe\Models;

use Webmaniabr\Mdfe\Enums\TipoProdutoPredominante;

class ProdutoPredominante
{
    /**
     * Tipo da Carga.
     * @see TipoProdutoPredominante
     * @var string
     */
    public string $tipoCarga;

    /**
     * Descrição do produto predominante.
     * @var string
     */
    public string $nome;

    /**
     * GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de barras.
     * @var string
     */
    public string $gtin;

    /**
     * Código NCM do Produto.
     * @var string
     */
    public string $ncm;

    /**
     * Informações da carga lotação de carregamento. Informar somente quando MDF-e for de carga lotação.
     * @var Lotacao
     */
    public Lotacao $LotacaoCarregamento;

    /**
     * Informações da carga lotação de descarregamento. Informar somente quando MDF-e for de carga lotação.
     * @var Lotacao
     */
    public Lotacao $LotacaoDescarregamento;

    public function __construct()
    {
        $this->LotacaoCarregamento = new Lotacao();
        $this->LotacaoDescarregamento = new Lotacao();
    }
}