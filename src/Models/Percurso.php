<?php

namespace Webmaniabr\Mdfe\Models;

/**
 * @method $this AC()
 * @method $this AL()
 * @method $this AP()
 * @method $this AM()
 * @method $this BA()
 * @method $this CE()
 * @method $this DF()
 * @method $this ES()
 * @method $this GO()
 * @method $this MA()
 * @method $this MT()
 * @method $this MS()
 * @method $this MG()
 * @method $this PA()
 * @method $this PB()
 * @method $this PR()
 * @method $this PE()
 * @method $this PI()
 * @method $this RJ()
 * @method $this RN()
 * @method $this RS()
 * @method $this RO()
 * @method $this RR()
 * @method $this SC()
 * @method $this SP()
 * @method $this SE()
 * @method $this TO()
 */
class Percurso
{
    const uf = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

    public array $percurso = [];

    public function __call($name, $arguments)
    {
        $uf = strtoupper($name);
        if (in_array($uf, self::uf)) {
            $this->percurso[] = $uf;
            return $this;
        }
        throw new \BadMethodCallException();
    }
}