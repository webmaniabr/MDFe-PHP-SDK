<?php

namespace Webmaniabr\Mdfe\Enums;

abstract class TipoUnidadeTransporte
{
    const RODOVIARIO_TRACAO  = 1,
          RODOVIARIO_REBOQUE = 2,
          NAVIO              = 3,
          BALSA              = 4,
          AERONAVE           = 5,
          VAGAO              = 6,
          OUTROS             = 7;
}