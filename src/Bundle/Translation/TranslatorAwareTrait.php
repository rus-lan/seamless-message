<?php

namespace RusLan\SeamlessMessage\Bundle\Translation;

use Symfony\Contracts\Translation\TranslatorInterface;

trait TranslatorAwareTrait
{
    /**
     * @var TranslatorInterface|null
     */
    protected $translator;

    /**
     * @return TranslatorInterface|null
     */
    public function getTranslator(): ?TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @param TranslatorInterface|null $translator
     *
     * @return static
     */
    public function setTranslator(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;

        return $this;
    }
}
