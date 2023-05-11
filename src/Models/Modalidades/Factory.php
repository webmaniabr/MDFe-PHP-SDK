<?php

namespace Webmaniabr\Mdfe\Models\Modalidades;

use Webmaniabr\Mdfe\Interfaces\TransportMode;

class Factory
{
    /**
     * @param int $modality
     * @return TransportMode|Rodoviario|Aquaviario|Ferroviario|Aereo
     */
    public static function loadByModality(int $modality): TransportMode
    {
        switch ($modality) {
            case 1:
                return new Rodoviario();
            case 2:
                return new Aereo();
            case 3:
                return new Aquaviario();
            case 4:
                return new Ferroviario();
        }
    }
}