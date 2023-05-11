<?php

namespace Webmaniabr\Mdfe\Models;

class Descarregamento
{
    /**
     * Nome do Município de Carregamento.
     * @var string
     */
    public string $nomeMunicipio;

    /**
     * Código do Município de Carregamento.
     * @var string
     */
    public string $codigoMunicipio;

    /**
     * Documentos Fiscais das mercadorias que serão descarregadas no município NF-e, CT-e ou MDF-e.
     * @var DocumentoFiscal[]
     */
    public array $DocumentosFiscais = [];

    /**
     * Adiciona e retorna novo documento.
     * @return DocumentoFiscal
     */
    public function newDocumentoFiscal()
    {
        $DocumentoFiscal = new DocumentoFiscal();
        $this->DocumentosFiscais[] = $DocumentoFiscal;
        return $DocumentoFiscal;
    }

    /**
     * Adiciona novo documento.
     * @param DocumentoFiscal $documentoFiscal
     */
    public function addDocumentoFiscal(DocumentoFiscal $documentoFiscal)
    {
        $this->DocumentosFiscais[] = $documentoFiscal;
    }
}