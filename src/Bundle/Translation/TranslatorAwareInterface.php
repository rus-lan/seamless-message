<?php

namespace RusLan\SeamlessMessage\Bundle\Translation;

use Symfony\Contracts\Translation\TranslatorInterface;

interface TranslatorAwareInterface
{
    /**
     * @return TranslatorInterface|null
     */
    public function getTranslator(): ?TranslatorInterface;

    /**
     * @param TranslatorInterface|null $translator
     *
     * @return static
     */
    public function setTranslator(?TranslatorInterface $translator = null);
}
