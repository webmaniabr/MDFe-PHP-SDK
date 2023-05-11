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
use Webmaniabr\Mdfe\Models\Modalidades\Rodoviario\Condutor;

class AddDriver implements APIOperation
{
    protected stdClass $toSend;

    /**
     * @var MDFe
     */
    private MDFe $MDFe;

    /**
     * @var Condutor
     */
    private Condutor $Condutor;

    /**
     * Define o MDFe de consulta.
     * @param MDFe $MDFe
     */
    public function setMDFe(MDFe $MDFe)
    {
        $this->MDFe = $MDFe;
    }

    /**
     * Define o novo condutor.
     * @param Condutor $Condutor
     */
    public function setCondutor(Condutor $Condutor): void
    {
        $this->Condutor = $Condutor;
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
        return new Endpoint('/2/mdfe/condutor', 'PUT', [ 'Authorization' => 'Bearer '. Connection::getInstance()->getBearerToken(),
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
     * Cria o JSON de envio.
     */
    protected function makeJSON()
    {
        $this->toSend = new stdClass();
        if (isset($this->MDFe->uuid)) {
            $this->toSend->uuid =$this->MDFe->uuid;
        } else if (isset($this->MDFe->chave)) {
            $this->toSend->chave =$this->MDFe->chave;
        }
        if (isset($this->Condutor)) {
            $this->toSend->cpf = $this->Condutor->cpf;
            $this->toSend->nome = $this->Condutor->nome;
        }
    }
}