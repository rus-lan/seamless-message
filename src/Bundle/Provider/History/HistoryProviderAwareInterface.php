<?php

namespace RusLan\SeamlessMessage\Bundle\Provider\History;

interface HistoryProviderAwareInterface
{
    public function getHistoryProvider(): ?HistoryProvider;

    /**
     * @param HistoryProvider|null $historyProvider
     * @return static
     */
    public function setHistoryProvider(?HistoryProvider $historyProvider = null);
}
