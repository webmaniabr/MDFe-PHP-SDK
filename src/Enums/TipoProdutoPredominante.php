<?php

namespace Webmaniabr\Mdfe\Enums;

abstract class TipoProdutoPredominante
{
    const GRANEL_SOLIDO           = '01',
          GRANEL_LIQUIDO          = '02',
          FRIGORIFICADA           = '03',
          CONTEINERIZADA          = '04',
          CARGA_GERAL             = '05',
          NEOGRANEL               = '06',
          PERIGOSA_GRANEL_SOLIDO  = '07',
          PERIGOSA_GRANEL_LIQUIDO = '08',
          PERIGOSA_FRIGORIFICADA  = '09',
          PERIGOSA_CONTEINERIZADA = '10',
          PERIGOSA_CARGA_GERAL    = '11';
}