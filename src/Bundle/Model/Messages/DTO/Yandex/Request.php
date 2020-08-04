<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class Request
{
    /** @var string|null */
    protected $command;

    /** @var string|null */
    protected $originalUtterance;

    /** @var RequestNlu|null */
    protected $nlu;

    /** @var RequestMarkup|null */
    protected $markup;

    /** @var string|null */
    protected $type;

    /** @var object|null */
    protected $source;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->source = $data;

        $this->command = $data->command ?? null;
        $this->originalUtterance = $data->original_utterance ?? null;
        $this->type = $data->type ?? null;

        if (isset($data->nlu)) {
            $this->nlu = new RequestNlu($data->nlu);
        }
        if (isset($data->markup)) {
            $this->markup = new RequestMarkup($data->markup);
        }
    }

    /**
     * @return object|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function isNlu(): bool
    {
        return $this->nlu instanceof RequestNlu;
    }

    /**
     * @return bool
     */
    public function isMarkup(): bool
    {
        return $this->markup instanceof RequestMarkup;
    }

    /**
     * @return string|null
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return string|null
     */
    public function getOriginalUtterance(): ?string
    {
        return $this->originalUtterance;
    }

    /**
     * @return RequestNlu|null
     */
    public function getNlu(): ?RequestNlu
    {
        return $this->nlu;
    }

    /**
     * @return RequestMarkup|null
     */
    public function getMarkup(): ?RequestMarkup
    {
        return $this->markup;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
