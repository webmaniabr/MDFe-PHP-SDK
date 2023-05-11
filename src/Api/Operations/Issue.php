<?php

namespace Webmaniabr\Mdfe\Api\Operations;

use stdClass;
use Webmaniabr\Mdfe\Api\Connection;
use Webmaniabr\Mdfe\Api\Endpoint;
use Webmaniabr\Mdfe\Api\Exceptions\APIException;
use Webmaniabr\Mdfe\Api\Http\Client;
use Webmaniabr\Mdfe\Interfaces\APIOperation;
use Webmaniabr\Mdfe\Interfaces\APIResponse;
use Webmaniabr\Mdfe\Interfaces\DocumentForIssuance;
use Webmaniabr\Mdfe\Models\MDFe;

class Issue implements APIOperation
{
    protected stdClass $toSend;

    /**
     * @var DocumentForIssuance|MDFe
     */
    protected DocumentForIssuance $ForIssuance;
    protected bool $productionEnviroment = true;

    /**
     * Define o Documento que será emitido.
     * @param DocumentForIssuance $Document
     */
    public function setDocumentForIssuance(DocumentForIssuance $Document)
    {
        $this->ForIssuance = $Document;
    }

    /**
     * Define se será utilizado o ambiente de produção.
     * @param bool $prodEnviroment
     */
    public function setProductionEnviroment(bool $prodEnviroment)
    {
        $this->productionEnviroment = $prodEnviroment;
    }

    /**
     * {@inheritDoc}
     */
    public function getContentToSend()
    {
        return json_encode($this->toSend);
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpoint() : Endpoint
    {
        return new Endpoint('/2/mdfe/emissao', 'POST', [ 'Authorization' => 'Bearer '. Connection::getInstance()->getBearerToken(),
            'Content-Type'  => 'application/json' ]);
    }

    /**
     * {@inheritDoc}
     */
    public function execute() : APIResponse
    {
        $this->makeJSON();
        return (new Client())->send($this);
    }

    /**
     * Cria o JSON de emissão.
     */
    protected function makeJSON()
    {
        $this->toSend = new stdClass();
        $this->toSend->ambiente = $this->productionEnviroment ? 1 : 2;
        if (!is_null($this->ForIssuance->getUrlNotificacao())) {
            $this->toSend->url_notificacao = $this->ForIssuance->getUrlNotificacao();
        }
        $this->convertDocumentToJSON();
        $this->removeEmptyProperties($this->toSend);
    }

    /**
     * Cria o JSON do MDFe.
     * @throws APIException
     */
    private function convertDocumentToJSON()
    {
        $this->toSend->emitente = $this->ForIssuance->emitente ?? null;
        $this->toSend->transportador = $this->ForIssuance->transportador ?? null;
        if (!isset($this->ForIssuance->Modalidade)) {
            throw new APIException('É obrigatória a escolha de uma das modalidades');
        }
        $this->toSend->modalidade = $this->ForIssuance->Modalidade->getCode();
        $this->toSend->uf_carregamento = $this->ForIssuance->ufCarregamento ?? null;
        $this->toSend->uf_descarregamento = $this->ForIssuance->ufDescarregamento ?? null;
        $this->toSend->valor_carga = $this->ForIssuance->valorCarga ?? null;
        $this->toSend->unidade = $this->ForIssuance->unidade ?? null;
        $this->toSend->peso_bruto = $this->ForIssuance->pesoBruto ?? null;
        if (isset($this->ForIssuance->InicioViagem)) {
            $this->toSend->data_inicio_viagem = $this->ForIssuance->InicioViagem->format('Y-m-d H:i:s');
        }
        $this->toSend->carregamento = [];
        foreach ($this->ForIssuance->Carregamentos as $Carregamento) {
            $this->toSend->carregamento[] = (object) [ 'nome_municipio' => $Carregamento->nomeMunicipio ?? null,
                                                       'codigo_municipio' => $Carregamento->codigoMunicipio ?? null ];
        }
        $this->toSend->descarregamento = [];
        foreach ($this->ForIssuance->Descarregamentos as $Descarregamento) {
            $documentosFiscais = [];
            foreach ($Descarregamento->DocumentosFiscais as $DocumentoFiscal) {
                $unidadesTransporte = [];
                foreach ($DocumentoFiscal->unidadesTransporte as $UnidadeTransporte) {
                    $unidadesCarga = [];
                    foreach ($UnidadeTransporte->unidadesCarga as $UnidadeCarga) {
                        $unidadesCarga[] = (object) [ 'tipo' => $UnidadeCarga->tipo ?? null,
                                                      'identificacao' => $UnidadeCarga->identificacao ?? null,
                                                      'lacres' => $UnidadeCarga->lacres ?? null,
                                                      'quantidade_rateada' => $UnidadeCarga->quantidadeRateada ?? null ];
                    }
                    $unidadesTransporte[] = (object) [ 'tipo' => $UnidadeTransporte->tipo ?? null,
                                                       'identificacao' => $UnidadeTransporte->identificacao ?? null,
                                                       'lacres' => $UnidadeTransporte->lacres ?? null,
                                                       'quantidade_rateada' => $UnidadeTransporte->quantidadeRateada ?? null,
                                                       'unidade_carga' => $unidadesCarga ?? null ];
                }
                $documentosFiscais[] = (object) [ 'chave' => $DocumentoFiscal->chave ?? null,
                                                  'codigo_barra' => $DocumentoFiscal->codigoBarras ?? null,
                                                  'indicador_reentrega' => $DocumentoFiscal->indicadorReentrega ?? null,
                                                  'unidade_transporte' => $unidadesTransporte ?? null ];
            }
            $this->toSend->descarregamento[] = (object) [ 'nome_municipio' => $Descarregamento->nomeMunicipio ?? null,
                                                          'codigo_municipio' => $Descarregamento->codigoMunicipio ?? null,
                                                          'documentos_fiscais' => $documentosFiscais ?? null ];
        }
        $this->toSend->percurso = $this->ForIssuance->Percurso->percurso;
        $this->toSend->produto_predominante = (object) [ 'tipo_carga' => $this->ForIssuance->ProdutoPredominante->tipoCarga ?? null,
                                                         'nome' => $this->ForIssuance->ProdutoPredominante->nome ?? null,
                                                         'gtin' => $this->ForIssuance->ProdutoPredominante->gtin ?? null,
                                                         'ncm' => $this->ForIssuance->ProdutoPredominante->ncm ?? null,
                                                         'lotacao' => (object) [ 'carregamento' => (object) [ 'cep' => $this->ForIssuance->ProdutoPredominante->LotacaoCarregamento->cep ?? null,
                                                                                                              'latitude' => $this->ForIssuance->ProdutoPredominante->LotacaoCarregamento->latitude ?? null,
                                                                                                              'longitude' => $this->ForIssuance->ProdutoPredominante->LotacaoCarregamento->longitude ?? null ],
                                                                                 'descarregamento' => (object) [ 'cep' => $this->ForIssuance->ProdutoPredominante->LotacaoDescarregamento->cep ?? null,
                                                                                                                 'latitude' => $this->ForIssuance->ProdutoPredominante->LotacaoDescarregamento->latitude ?? null,
                                                                                                                 'longitude' => $this->ForIssuance->ProdutoPredominante->LotacaoDescarregamento->longitude ?? null ] ] ];
        $this->toSend->seguro = [];
        foreach ($this->ForIssuance->Seguros as $Seguro) {
            $this->toSend->seguro[] = (object) [ 'responsavel' => (object) [ 'tipo_responsavel' => $Seguro->Responsavel->tipoResponsavel ?? null,
                                                                             'cnpj' => $Seguro->Responsavel->cnpj ?? null,
                                                                             'cpf' => $Seguro->Responsavel->cpf ?? null ],
                                                 'seguradora' => (object) [ 'nome_seguradora' => $Seguro->Seguradora->nome ?? null,
                                                                            'cnpj' => $Seguro->Seguradora->cnpj ?? null ],
                                                 'numero_apolice' => $Seguro->numeroApolice ?? null,
                                                 'numero_averbacao' => $Seguro->numerosAverbacoes ?? null ];
        }
        switch ($this->ForIssuance->Modalidade->getCode()) {
            case 1:
                $this->makeJSONRodoviario();
                break;
            case 2:
                $this->makeJSONAereo();
                break;
            case 3:
                $this->makeJSONAquaviario();
                break;
            case 4:
                $this->makeJSONFerroviario();
                break;
        }
    }

    /**
     * Cria o JSON para o modelo rodoviário.
     */
    private function makeJSONRodoviario()
    {
        $Rodoviario = $this->ForIssuance->Rodoviario();
        $VeiculosReboque = [];
        foreach ($Rodoviario->VeiculosReboque as $VeiculoReboque) {
            $VeiculosReboque[] = (object) [ 'codigo_interno' => $VeiculoReboque->codigoInterno ?? null,
                                            'placa' => $VeiculoReboque->placa ?? null,
                                            'renavam' => $VeiculoReboque->renavam ?? null,
                                            'tara' => $VeiculoReboque->tara ?? null,
                                            'capacidade_kg' => $VeiculoReboque->capacidadeKg ?? null,
                                            'capacidade_m3' => $VeiculoReboque->capacidadeM3 ?? null,
                                            'tipo_rodado' => $VeiculoReboque->tipoRodado ?? null,
                                            'tipo_carroceria' => $VeiculoReboque->tipoCarroceria ?? null,
                                            'uf_licenciamento' => $VeiculoReboque->ufLicenciamento ?? null,
                                            'proprietario' => (object) [ 'cpf' => $VeiculoReboque->Proprietario->cpf ?? null,
                                                                         'cnpj' => $VeiculoReboque->Proprietario->cnpj ?? null,
                                                                         'nome_completo' => $VeiculoReboque->Proprietario->nomeCompleto ?? null,
                                                                         'razao_social' => $VeiculoReboque->Proprietario->razaoSocial ?? null,
                                                                         'ie' => $VeiculoReboque->Proprietario->ie ?? null,
                                                                         'rntrc' => $VeiculoReboque->Proprietario->rntrc ?? null,
                                                                         'uf' => $VeiculoReboque->Proprietario->uf ?? null,
                                                                         'tipo_proprietario' => $VeiculoReboque->Proprietario->tipoProprietario ?? null ] ];
        }
        $Condutores = [];
        foreach ($Rodoviario->Condutores as $Condutor) {
            $Condutores[] = (object) [ 'cpf' => $Condutor->cpf ?? null,
                                       'nome' => $Condutor->nome ?? null ];
        }
        $CIOTs = [];
        foreach ($Rodoviario->Ciot as $CIOT) {
            $CIOTs[] = (object) [ 'codigo_ciot' => $CIOT->codigoCiot ?? null,
                                  'cpf_responsavel' => $CIOT->cpfResponsavel ?? null,
                                  'cnpj_responsavel' => $CIOT->cnpjResponsavel ?? null ];
        }
        $ValesPedagio = [];
        foreach ($Rodoviario->ValesPedagio as $ValePedagio) {
            $ValesPedagio[] = (object) [ 'cnpj_fornecedor' => $ValePedagio->cnpjFornecedor ?? null,
                                         'cpf_responsavel' => $ValePedagio->cpfResponsavel ?? null,
                                         'cnpj_responsavel' => $ValePedagio->cnpjResponsavel ?? null,
                                         'comprovante' => $ValePedagio->comprovante ?? null,
                                         'valor' => $ValePedagio->valor ?? null ];
        }
        $Contratantes = [];
        foreach ($Rodoviario->Contratantes as $Contratante) {
            $Contratantes[] = (object) [ 'cpf' => $Contratante->cpf ?? null,
                                         'cnpj' => $Contratante->cnpj ?? null ];
        }
        $this->toSend->rodoviario = (object) [ 'rntrc' => $Rodoviario->rntrc ?? null,
                                               'veiculo_tracao' => (object) [ 'codigo_interno' => $Rodoviario->VeiculoTracao->codigoInterno ?? null,
                                                                              'placa' => $Rodoviario->VeiculoTracao->placa ?? null,
                                                                              'renavam' => $Rodoviario->VeiculoTracao->renavam ?? null,
                                                                              'tara' => $Rodoviario->VeiculoTracao->tara ?? null,
                                                                              'capacidade_kg' => $Rodoviario->VeiculoTracao->capacidadeKg ?? null,
                                                                              'capacidade_m3' => $Rodoviario->VeiculoTracao->capacidadeM3 ?? null,
                                                                              'tipo_rodado' => $Rodoviario->VeiculoTracao->tipoRodado ?? null,
                                                                              'tipo_carroceria' => $Rodoviario->VeiculoTracao->tipoCarroceria ?? null,
                                                                              'uf_licenciamento' => $Rodoviario->VeiculoTracao->ufLicenciamento ?? null,
                                                                              'proprietario' => (object) [ 'cpf' => $Rodoviario->VeiculoTracao->Proprietario->cpf ?? null,
                                                                                                           'cnpj' => $Rodoviario->VeiculoTracao->Proprietario->cnpj ?? null,
                                                                                                           'nome_completo' => $Rodoviario->VeiculoTracao->Proprietario->nomeCompleto ?? null,
                                                                                                           'razao_social' => $Rodoviario->VeiculoTracao->Proprietario->razaoSocial ?? null,
                                                                                                           'ie' => $Rodoviario->VeiculoTracao->Proprietario->ie ?? null,
                                                                                                           'rntrc' => $Rodoviario->VeiculoTracao->Proprietario->rntrc ?? null,
                                                                                                           'uf' => $Rodoviario->VeiculoTracao->Proprietario->uf ?? null,
                                                                                                           'tipo_proprietario' => $Rodoviario->VeiculoTracao->Proprietario->tipoProprietario ?? null ] ],
                                               'veiculo_reboque' => $VeiculosReboque,
                                               'condutor' => $Condutores,
                                               'ciot' => $CIOTs,
                                               'vale_pedagio' => $ValesPedagio,
                                               'contratante' => $Contratantes ];
    }

    /**
     * Cria o JSON para o modelo aéreo.
     */
    private function makeJSONAereo()
    {
        $Aereo = $this->ForIssuance->Aereo();
        $this->toSend->aereo = (object) [ 'nacionalidade_aeronave' => $Aereo->nacionalidadeAeronave ?? null,
                                          'matricula_aeronave' => $Aereo->matriculaAeronave ?? null,
                                          'numero_voo' => $Aereo->numeroVoo ?? null,
                                          'aerodromo_embarque' => $Aereo->aerodromoEmbarque ?? null,
                                          'aerodromo_destino' => $Aereo->aerodromoDestino ?? null,
                                          'data_voo' => isset($Aereo->dataVoo) ? $Aereo->dataVoo->format('Y-m-d') : null ];
    }

    /**
     * Cria o JSON para o modelo aquaviário.
     */
    private function makeJSONAquaviario()
    {
        $Aquaviario = $this->ForIssuance->Aquaviario();
        $TerminaisCarregamento = [];
        foreach ($Aquaviario->TerminaisCarregamento as $TerminalCarregamento) {
            $TerminaisCarregamento[] = (object) [ 'codigo' => $TerminalCarregamento->codigo ?? null,
                                                  'nome' => $TerminalCarregamento->nome ?? null ];
        }
        $TerminaisDescarregamento = [];
        foreach ($Aquaviario->TerminaisDescarregamento as $TerminalDescarregamento) {
            $TerminaisDescarregamento[] = (object) [ 'codigo' => $TerminalDescarregamento->codigo ?? null,
                                                     'nome' => $TerminalDescarregamento->nome ?? null ];
        }
        $EmbarcacoesComboio = [];
        foreach ($Aquaviario->EmbarcacoesComboio as $EmbarcacaoComboio) {
            $EmbarcacoesComboio[] = (object) [ 'codigo' => $EmbarcacaoComboio->codigo ?? null,
                                               'identificador_balsa' => $EmbarcacaoComboio->identificadorBalsa ?? null ];
        }
        $CargasVazia = [];
        foreach ($Aquaviario->CargasVazias as $CargaVazia) {
            $CargasVazia[] = (object) [ 'identificador' => $CargaVazia->identificador ?? null,
                                        'tipo_unidade' => $CargaVazia->tipoUnidade ?? null ];
        }
        $TransportesVazio = [];
        foreach ($Aquaviario->TransportesVazios as $TransporteVazio) {
            $TransportesVazio[] = (object) [ 'identificador' => $TransporteVazio->identificador ?? null,
                                             'tipo_unidade' => $TransporteVazio->tipoUnidade ?? null ];
        }
        $this->toSend->aquaviario = (object) [ 'irin' => $Aquaviario->irin ?? null,
                                               'tipo_embarcacao' => $Aquaviario->tipoEmbarcacao ?? null,
                                               'codigo_embarcacao' => $Aquaviario->codigoEmbarcacao ?? null,
                                               'nome_embarcacao' => $Aquaviario->nomeEmbarcacao ?? null,
                                               'numero_viagem' => $Aquaviario->numeroViagem ?? null,
                                               'codigo_porto_embarque' => $Aquaviario->codigoPortoEmbarque ?? null,
                                               'codigo_porto_destino' => $Aquaviario->codigoPortoDestino ?? null,
                                               'porto_transbordo' => $Aquaviario->portoTransbordo ?? null,
                                               'tipo_navegacao' => $Aquaviario->tipoNavegacao ?? null,
                                               'terminal_carregamento' => $TerminaisCarregamento ?? null,
                                               'terminal_descarregamento' => $TerminaisDescarregamento ?? null,
                                               'embarcacao_comboio' => $EmbarcacoesComboio ?? null,
                                               'carga_vazia' => $CargasVazia ?? null,
                                               'transporte_vazio' => $TransportesVazio ?? null ];
    }

    /**
     * Cria o JSON para o modelo ferroviário.
     */
    private function makeJSONFerroviario()
    {
        $Ferroviario = $this->ForIssuance->Ferroviario();
        $Vagoes = [];
        foreach ($Ferroviario->Vagoes as $Vagao) {
            $Vagoes[] = (object) [ 'peso_bc' => $Vagao->pesoBC ?? null,
                                   'peso_real' => $Vagao->pesoReal ?? null,
                                   'tipo_vagao' => $Vagao->tipoVagao ?? null,
                                   'serie' => $Vagao->serie ?? null,
                                   'numero' => $Vagao->numero ?? null,
                                   'sequencia_vagao' => $Vagao->sequenciaVagao ?? null,
                                   'tonelada_util' => $Vagao->toneladaUtil ?? null ];
        }
        $this->toSend->ferroviario = (object) [ 'trem' => (object) [ 'prefixo' => $Ferroviario->Trem->prefixo ?? null,
                                                                     'data_liberacao' => isset($Ferroviario->Trem->dataLiberacao) ? $Ferroviario->Trem->dataLiberacao->format('Y-m-d H:i:s') : null,
                                                                     'origem' => $Ferroviario->Trem->origem ?? null,
                                                                     'destino' => $Ferroviario->Trem->destino ?? null ],
                                                'vagoes' => $Vagoes ];
    }

    /**
     * Remove do JSON tudo que não foi informado.
     * @param $json
     */
    private function removeEmptyProperties(&$json)
    {
        foreach ($json as $key => $property) {
            if (empty($property)) {
                unset($json->{$key});
            } else if (!is_scalar($property)) {
                $this->removeEmptyProperties($property);
                $arrayProperty = (array) $property;
                if (empty($arrayProperty) && !in_array($key, [ 'aereo', 'rodoviario', 'aquaviario' , 'ferroviario'])) {
                    unset($json->{$key});
                }
            }
        }
    }
}