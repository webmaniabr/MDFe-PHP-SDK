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

class Consult implements APIOperation
{
    /**
     * @var MDFe
     */
    private MDFe $MDFe;

    /**
     * Define o MDFe de consulta.
     * @param MDFe $MDFe
     */
    public function setMDFe(MDFe $MDFe)
    {
        $this->MDFe = $MDFe;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getContentToSend()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpoint() : Endpoint
    {
        return new Endpoint("/2/mdfe/consulta/{$this->MDFe->chave}", 'POST', [ 'Authorization' => 'Bearer '. Connection::getInstance()->getBearerToken(),
            'Content-Type'  => 'application/json' ]);
    }

    /**
     * {@inheritDoc}
     */
    public function execute() : APIResponse
    {
        return (new Client())->send($this);
    }
}