<?php

namespace Webmaniabr\Mdfe\Interfaces;

interface OptionalObjectParameter
{
    /**
     * Deve retornar se o parâmetro deverá ser utilizado no JSON.
     * @return bool
     */
    public function hasRequiredValues() : bool;
}