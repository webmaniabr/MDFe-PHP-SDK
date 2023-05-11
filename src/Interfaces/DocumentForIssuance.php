<?php

namespace Webmaniabr\Mdfe\Interfaces;

use DateTime;

interface DocumentForIssuance
{
    /**
     * Retorna a URL de notificação.
     * @return string|null
     */
    public function getUrlNotificacao();

    /**
     * Emite o documento em ambiente de Produção.
     * @return APIResponse
     */
    public function emitir() : APIResponse;

    /**
     * Emite o documento em ambiente de Homologação.
     * @return APIResponse
     */
    public function emitirHomologacao() : APIResponse;
}