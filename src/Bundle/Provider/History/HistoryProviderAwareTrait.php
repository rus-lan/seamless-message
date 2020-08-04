<?php

namespace RusLan\SeamlessMessage\Bundle\Provider\History;

trait HistoryProviderAwareTrait
{
    /**
     * @var HistoryProvider|null
     */
    protected $historyProvider;

    public function getHistoryProvider(): ?HistoryProvider
    {
        return $this->historyProvider;
    }

    /**
     * @param HistoryProvider|null $historyProvider
     * @return static
     */
    public function setHistoryProvider(?HistoryProvider $historyProvider = null)
    {
        $this->historyProvider = $historyProvider;

        return $this;
    }
}
