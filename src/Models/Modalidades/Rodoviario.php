<?php

namespace Webmaniabr\Mdfe\Models\Modalidades;

use Webmaniabr\Mdfe\Interfaces\TransportMode;
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\CIOT;
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\Condutor;
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\Contratante;
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\ValePedagio;
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\Veiculo;

class Rodoviario implements TransportMode
{
    /**
     * Registro Nacional de Transportadores Rodoviários de Carga.
     * @var string
     */
    public string $rntrc;

    /**
     * Informações do Veículo de Tração.
     * @var Veiculo
     */
    public Veiculo $VeiculoTracao;

    /**
     * Informações dos Veículos de Reboque
     * @var Veiculo[]
     */
    public array $VeiculosReboque = [];

    /**
     * Condutores do Veículo.
     * @var Condutor[]
     */
    public array $Condutores = [];

    /**
     * Dados do CIOT (Código Identificador da Operação de Transporte).
     * @var CIOT[]
     */
    public array $Ciot = [];

    /**
     * Informações de Vale Pedágio.
     * @var ValePedagio[]
     */
    public array $ValesPedagio = [];

    /**
     * Informações dos Contratantes do Serviço de Transporte.
     * @var Contratante[]
     */
    public array $Contratantes = [];

    /**
     * Adiciona um novo contratante.
     * @param Contratante $Contratante
     */
    public function addContratante(Contratante $Contratante)
    {
        $this->Contratantes[] = $Contratante;
    }

    /**
     * Cria e retorna um novo contratante.
     * @return Contratante
     */
    public function newContratante()
    {
        $Contratante = new Contratante();
        $this->Contratantes[] = $Contratante;
        return $Contratante;
    }

    /**
     * Adiciona um novo vale pedágio.
     * @param ValePedagio $ValePedagio
     */
    public function addValePedagio(ValePedagio $ValePedagio)
    {
        $this->ValesPedagio[] = $ValePedagio;
    }

    /**
     * Cria e e retorna um novo Vale Pedágio.
     * @return ValePedagio
     */
    public function newValePedagio()
    {
        $ValePedagio = new ValePedagio();
        $this->ValesPedagio[] = $ValePedagio;
        return $ValePedagio;
    }

    /**
     * Adiciona um novo CIOT.
     * @param CIOT $Ciot
     */
    public function addCIOT(CIOT $Ciot)
    {
        $this->Ciot[] = $Ciot;
    }

    /**
     * Cria e retorna um novo CIOT.
     * @return CIOT
     */
    public function newCIOT()
    {
        $Ciot = new CIOT();
        $this->Ciot[] = $Ciot;
        return $Ciot;
    }
    
    /**
     * Adiciona um novo condutor.
     * @param Condutor $Condutor
     */
    public function addCondutor(Condutor $Condutor)
    {
        $this->Condutores[] = $Condutor;
    }

    /**
     * Cria e retorna um novo Condutor.
     * @return Condutor
     */
    public function newCondutor()
    {
        $Condutor = new Condutor();
        $this->Condutores[] = $Condutor;
        return $Condutor;
    }

    /**
     * Adiciona um novo veículo de reboque.
     * @param Veiculo $VeiculoReboque
     */
    public function addVeiculoReboque(Veiculo $VeiculoReboque)
    {
        $this->VeiculosReboque[] = $VeiculoReboque;
    }

    /**
     * Cria e retorna um novo veículo de reboque.
     * @return Veiculo
     */
    public function newVeiculoReboque()
    {
        $VeiculoReboque = new Veiculo();
        $this->VeiculosReboque[] = $VeiculoReboque;
        return $VeiculoReboque;
    }

    /**
     * {@inheritDoc}
     */
    public function getCode(): int
    {
        return 1;
    }
}