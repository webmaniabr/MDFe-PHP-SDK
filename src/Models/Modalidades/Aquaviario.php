<?php

namespace Webmaniabr\Mdfe\Models\Modalidades;

use Webmaniabr\Mdfe\Enums\TipoNavegacao;
use Webmaniabr\Mdfe\Interfaces\TransportMode;
use Webmaniabr\Mdfe\Models\Modalidades\Aquaviario\UnidadeVazia;
use Webmaniabr\Mdfe\Models\Modalidades\Aquaviario\EmbarcacaoComboio;
use Webmaniabr\Mdfe\Models\Modalidades\Aquaviario\Terminal;

class Aquaviario implements TransportMode
{
    /**
     * Irin do navio.
     * @var string
     */
    public string $irin;

    /**
     * Código do tipo de embarcação.
     * @var string
     */
    public string $tipoEmbarcacao;

    /**
     * Código da embarcação.
     * @var string
     */
    public string $codigoEmbarcacao;

    /**
     * Nome da embarcação.
     * @var string
     */
    public string $nomeEmbarcacao;

    /**
     * Número da viagem.
     * @var string
     */
    public string $numeroViagem;

    /**
     * Código do Porto de Embarque.
     * @var string
     */
    public string $codigoPortoEmbarque;

    /**
     * Código do Porto de Destino.
     * @var string
     */
    public string $codigoPortoDestino;

    /**
     * Porto de Transbordo.
     * @var string
     */
    public string $portoTransbordo;

    /**
     * Tipo de navegação.
     * @see TipoNavegacao
     * @var string
     */
    public string $tipoNavegacao;

    /**
     * Informações dos Terminais de Carregamento.
     * @var Terminal[]
     */
    public array $TerminaisCarregamento = [];

    /**
     * Informações dos Terminais de Descarregamento.
     * @var Terminal[]
     */
    public array $TerminaisDescarregamento = [];

    /**
     * Informações das Embarcações do Comboio.
     * @var EmbarcacaoComboio[]
     */
    public array $EmbarcacoesComboio = [];

    /**
     * Informações das Unidades de Carga vazias.
     * @var UnidadeVazia[]
     */
    public array $CargasVazias = [];

    /**
     * Informações das Unidades de Transporte vazias.
     * @var UnidadeVazia[]
     */
    public array $TransportesVazios = [];

    /**
     * Adiciona um novo transporte vazio.
     * @param UnidadeVazia $TransporteVazio
     */
    public function addTransporteVazio(UnidadeVazia $TransporteVazio)
    {
        $this->TransportesVazios[] = $TransporteVazio;
    }

    /**
     * Adiciona e retorna um novo transporte vazio.
     * @return UnidadeVazia
     */
    public function newTransporteVazio()
    {
        $TransporteVazio = new UnidadeVazia();
        $this->TransportesVazios[] = $TransporteVazio;
        return $TransporteVazio;
    }

    /**
     * Adiciona uma nova carga vazia.
     * @param UnidadeVazia $CargaVazia
     */
    public function addCargaVazia(UnidadeVazia $CargaVazia)
    {
        $this->CargasVazias[] = $CargaVazia;
    }

    /**
     * Adiciona e retorna uma nova carga vazia.
     * @return UnidadeVazia
     */
    public function newCargaVazia()
    {
        $CargaVazia = new UnidadeVazia();
        $this->CargasVazias[] = $CargaVazia;
        return $CargaVazia;
    }

    /**
     * Adiciona uma nova embarcação.
     * @param EmbarcacaoComboio $Embarcacao
     */
    public function addEmbarcacaoComboio(EmbarcacaoComboio $Embarcacao)
    {
        $this->EmbarcacoesComboio[] = $Embarcacao;
    }

    /**
     * Adiciona e retorna uma nova embarcação.
     * @return EmbarcacaoComboio
     */
    public function newEmbarcacaoComboio()
    {
        $Embarcacao = new EmbarcacaoComboio();
        $this->EmbarcacoesComboio[] = $Embarcacao;
        return $Embarcacao;
    }
    
    /**
     * Adiciona um novo Terminal de Carregamento.
     * @param Terminal $Terminal
     */
    public function addTerminalCarregamento(Terminal $Terminal)
    {
        $this->TerminaisCarregamento[] = $Terminal;
    }

    /**
     * Cria e retorna um novo Terminal de Carregamento.
     * @return Terminal
     */
    public function newTerminalCarregamento()
    {
        $Terminal = new Terminal();
        $this->TerminaisCarregamento[] = $Terminal;
        return $Terminal;
    }

    /**
     * Adiciona um novo Terminal de Descarregamento.
     * @param Terminal $Terminal
     */
    public function addTerminalDescarregamento(Terminal $Terminal)
    {
        $this->TerminaisDescarregamento[] = $Terminal;
    }

    /**
     * Cria e retorna um novo Terminal de Descarregamento.
     * @return Terminal
     */
    public function newTerminalDescarregamento()
    {
        $Terminal = new Terminal();
        $this->TerminaisDescarregamento[] = $Terminal;
        return $Terminal;
    }

    /**
     * {@inheritDoc}
     */
    public function getCode(): int
    {
        return 3;
    }
}