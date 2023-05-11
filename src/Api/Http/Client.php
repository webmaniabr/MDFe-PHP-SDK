<?php

namespace Webmaniabr\Mdfe\Api\Http;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Webmaniabr\Mdfe\Api\Connection;
use Webmaniabr\Mdfe\Api\Responses\FactoryResponse;
use Webmaniabr\Mdfe\Interfaces\APIOperation;
use Webmaniabr\Mdfe\Interfaces\APIResponse;

class Client
{
    /**
     * Envia a requisição de uma Operação da MDF-e.
     * @param APIOperation $operation
     * @return APIResponse
     */
    public function send(APIOperation $operation) : APIResponse
    {
        $endpoint = $operation->getEndpoint();
        $url = Connection::getInstance()->getDomain() . $endpoint->getUrl();
        $request = new Request($endpoint->getMethod(), $url, $endpoint->getHeaders(), $operation->getContentToSend());
        try {
            $response = (new GuzzleHttpClient())->sendAsync($request)->wait();
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
        }
        return FactoryResponse::getResponseInstance($response);
    }
}