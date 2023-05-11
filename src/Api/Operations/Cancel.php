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

class Cancel implements APIOperation
{
    protected stdClass $toSend;

    /**
     * @var MDFe
     */
    private MDFe $MDFe;

    /**
     * @var string
     */
    private string $motivo = '';

    /**
     * Define o MDFe de consulta.
     * @param MDFe $MDFe
     */
    public function setMDFe(MDFe $MDFe)
    {
        $this->MDFe = $MDFe;
    }

    /**
     * @param string $motivo
     */
    public function setMotivo(string $motivo): void
    {
        $this->motivo = $motivo;
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
        return new Endpoint('/2/mdfe/cancelar', 'PUT', [ 'Authorization' => 'Bearer '. Connection::getInstance()->getBearerToken(),
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
        if (isset($this->MDFe->uuid)) {
            $this->toSend->uuid =$this->MDFe->uuid;
        } else if (isset($this->MDFe->chave)) {
            $this->toSend->chave =$this->MDFe->chave;
        }
        $this->toSend->motivo = $this->motivo;
    }
}