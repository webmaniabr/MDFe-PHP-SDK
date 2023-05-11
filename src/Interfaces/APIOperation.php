<?php

namespace Webmaniabr\Mdfe\Interfaces;

use Webmaniabr\Mdfe\Api\Endpoint;

interface APIOperation
{
    /**
     * Retorna o Endpoint da operação.
     * @return Endpoint
     */
    public function getEndpoint() : Endpoint;

    /**
     * Executa a operação.
     * @return APIResponse
     */
    public function execute() : APIResponse;

    /**
     * Retorna o que será enviado no corpo da requisição.
     * @return mixed
     */
    public function getContentToSend();
}