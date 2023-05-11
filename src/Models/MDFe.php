<?php

namespace Webmaniabr\Mdfe\Models;

use Webmaniabr\Mdfe\Api\Operations\AddDriver;
use Webmaniabr\Mdfe\Api\Operations\Cancel;
use Webmaniabr\Mdfe\Api\Operations\Close;
use Webmaniabr\Mdfe\Api\Operations\Consult;
use Webmaniabr\Mdfe\Api\Operations\Issue;
use Webmaniabr\Mdfe\Api\Operations\Replace;
use Webmaniabr\Mdfe\Enums\TipoEmitente;
use Webmaniabr\Mdfe\Enums\TipoTransportador;
use Webmaniabr\Mdfe\Enums\UF;
use Webmaniabr\Mdfe\Enums\Unidade;
use Webmaniabr\Mdfe\Interfaces\APIResponse;
use Webmaniabr\Mdfe\Interfaces\DocumentForIssuance;
use Webmaniabr\Mdfe\Interfaces\TransportMode;
use Webmaniabr\Mdfe\Models\Modalidades\Aereo;
use Webmaniabr\Mdfe\Models\Modalidades\Aquaviario;
use Webmaniabr\Mdfe\Models\Modalidades\Factory;
use Webmaniabr\Mdfe\Models\Modalidades\Ferroviario;
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario;

/**
 * @see https://webmaniabr.com/docs/rest-api-mdfe/#emitir-mdfe
 */
class MDFe implements DocumentForIssuance
{
    /**
     * URL de notificação do status da MDF-e.
     * @var string
     * @see https://webmaniabr.com/docs/rest-api-mdfe/#notificacoes
     */
    public string $urlNotificacao;

    /**
     * Identificador único da MDF-e. Para consulta e Cancelamento.
     * @var string
     */
    public string $uuid = '';

    /**
     * Chave única da MDF-e. Para consulta e Cancelamento.
     * @var string
     */
    public string $chave = '';

    /**
     * Tipo do Emitente da MDF-e
     * @see TipoEmitente
     * @var int
     */
    public int $emitente;

    /**
     * Tipo do Transportador da MDF-e.
     * @see TipoTransportador
     * @var int
     */
    public int $transportador;

    /**
     * Sigla da UF do Carregamento
     * @see UF
     * @var string
     */
    public string $ufCarregamento;

    /**
     * Sigla da UF do Descarregamento
     * @see UF
     * @var string
     */
    public string $ufDescarregamento;

    /**
     * Valor total da carga/mercadorias transportadas
     * @var float
     */
    public float $valorCarga;

    /**
     * Código da unidade de medida do Peso Bruto da Carga/Mercadorias transportadas.
     * @see Unidade
     * @var string
     */
    public string $unidade;

    /**
     * Peso Bruto Total da Carga/Mercadorias transportadas.
     * @var float
     */
    public float $pesoBruto;

    /**
     * Data e hora previstos de início da viagem.
     * @var \DateTime
     */
    public \DateTime $InicioViagem;

    /**
     * Informações dos Municípios de Carregamento
     * @var Carregamento[]
     */
    public array $Carregamentos = [];

    /**
     * Informações dos Municípios de Descarregamento e Documentos Fiscais
     * @var Descarregamento[]
     */
    public array $Descarregamentos = [];

    /**
     * Informações do Produto Predominante da Carga.
     * @var ProdutoPredominante
     */
    public ProdutoPredominante $ProdutoPredominante;

    /**
     * Informações do Seguro da Carga.
     * @var Seguro[]
     */
    public array $Seguros = [];

    public Percurso $Percurso;

    /**
     * Modalidade do transporte.
     * @var TransportMode
     */
    public TransportMode $Modalidade;

    /**
     * Retorna a modalidade Rodoviária.
     * @return Rodoviario
     */
    public function Rodoviario(): Rodoviario
    {
        if (!isset($this->Modalidade) || !($this->Modalidade instanceof Rodoviario)) {
            $this->Modalidade = Factory::loadByModality(1);
        }
        return $this->Modalidade;
    }

    /**
     * Retorna a modalidade aérea.
     * @return Aereo
     */
    public function Aereo(): Aereo
    {
        if (!isset($this->Modalidade) || !($this->Modalidade instanceof Aereo)) {
            $this->Modalidade = Factory::loadByModality(2);
        }
        return $this->Modalidade;
    }

    /**
     * Retorna a modalidade ferroviária.
     * @return Ferroviario
     */
    public function Ferroviario(): Ferroviario
    {
        if (!isset($this->Modalidade) || !($this->Modalidade instanceof Ferroviario)) {
            $this->Modalidade = Factory::loadByModality(4);
        }
        return $this->Modalidade;
    }

    /**
     * Retorna a modalidade aquaviária.
     * @return Aquaviario
     */
    public function Aquaviario(): Aquaviario
    {
        if (!isset($this->Modalidade) || !($this->Modalidade instanceof Aquaviario)) {
            $this->Modalidade = Factory::loadByModality(3);
        }
        return $this->Modalidade;
    }

    /**
     * Adiciona um novo Seguro.
     * @param Seguro $Seguro
     */
    public function addSeguro(Seguro $Seguro)
    {
        $this->Seguros[] = $Seguro;
    }

    /**
     * Adiciona e retorna um novo Seguro.
     * @return Seguro
     */
    public function newSeguro()
    {
        $Seguro = new Seguro();
        $this->Seguros[] = $Seguro;
        return $Seguro;
    }
    
    /**
     * Adiciona e retorna um novo descarregamento.
     * @return Descarregamento
     */
    public function newDescarregamento(): Descarregamento
    {
        $Descarregamento = new Descarregamento();
        $this->Descarregamentos[] = $Descarregamento;
        return $Descarregamento;
    }

    /**
     * Adiciona um novo descarregamento
     * @param Descarregamento $Descarregamento
     */
    public function addDescarregamento(Descarregamento $Descarregamento)
    {
        $this->Descarregamentos[] = $Descarregamento;
    }

    /**
     * Adiciona e retorna novo local de carregamento.
     * @return Carregamento
     */
    public function newCarregamento(): Carregamento
    {
        $carregamento = new Carregamento();
        $this->Carregamentos[] = $carregamento;
        return $carregamento;
    }

    /**
     * Adiciona novo local de carregamento;
     * @param Carregamento $carregamento
     */
    public function addCarregamento(Carregamento $carregamento)
    {
        $this->Carregamentos[] = $carregamento;
    }

    public function __construct()
    {
        $this->ProdutoPredominante = new ProdutoPredominante();
        $this->Percurso = new Percurso();
    }

    /**
     * {@inheritDoc}
     */
    public function getUrlNotificacao()
    {
        if (isset($this->urlNotificacao)){
            return $this->urlNotificacao;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function emitir() : APIResponse
    {
        $issueOperation = new Issue();
        $issueOperation->setDocumentForIssuance($this);
        return $issueOperation->execute();
    }

    /**
     * {@inheritDoc}
     */
    public function emitirHomologacao() : APIResponse
    {
        $issueOperation = new Issue();
        $issueOperation->setDocumentForIssuance($this);
        $issueOperation->setProductionEnviroment(false);
        return $issueOperation->execute();
    }

    /**
     * Consulta a MDF-e.
     * @return APIResponse
     */
    public function consultar() : APIResponse
    {
        $consultOperation = new Consult();
        $consultOperation->setMDFe($this);
        return $consultOperation->execute();
    }

    /**
     * Encerra a MDF-e.
     * @param string $uf
     * @param string $municipio
     * @param string $municipioIBGE
     * @return APIResponse
     */
    public function encerrar(string $uf, string $municipio, string $municipioIBGE = '')
    {
        $closeOperation = new Close();
        $closeOperation->setMDFe($this);
        $closeOperation->setUf($uf);
        $closeOperation->setMunicipio($municipio);
        $closeOperation->setMunicipioIBGE($municipioIBGE);
        return $closeOperation->execute();
    }

    /**
     * Cancela a MDF-e
     * @param string $motivo
     * @return APIResponse
     */
    public function cancelar(string $motivo) : APIResponse
    {
        $cancelOperation = new Cancel();
        $cancelOperation->setMDFe($this);
        $cancelOperation->setMotivo($motivo);
        return $cancelOperation->execute();
    }

    public function incluirCondutor(Rodoviario\Condutor $Condutor)
    {
        $operationAddDriver = new AddDriver();
        $operationAddDriver->setMDFe($this);
        $operationAddDriver->setCondutor($Condutor);

    }
}