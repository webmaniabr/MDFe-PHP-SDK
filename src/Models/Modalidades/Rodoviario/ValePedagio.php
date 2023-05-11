<?php

namespace Webmaniabr\Mdfe\Models\Modalidades\Rodoviario;

class ValePedagio
{
    /**
     * Número do CNPJ do Fornecedor do Vale Pedágio.
     * @var string
     */
    public string $cnpjFornecedor;

    /**
     * Número do CPF do Responsável pelo pagamento do Vale Pedágio.
     * @var string
     */
    public string $cpfResponsavel;

    /**
     * Número do CNPJ do Responsável pelo pagamento do Vale Pedágio.
     * @var string
     */
    public string $cnpjResponsavel;

    /**
     * Número do comprovante de compra.
     * @var string
     */
    public string $comprovante;

    /**
     * Valor do Vale Pedágio.
     * @var string
     */
    public string $valor;
}