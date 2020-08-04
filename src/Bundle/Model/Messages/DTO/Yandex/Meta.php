<?php


namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Yandex;

class Meta
{
    /** @var string|null */
    protected $locale;

    /** @var string|null */
    protected $timezone;

    /** @var MetaInterfaces|null */
    protected $interfaces;

    /** @var object|null */
    protected $source;

    /**
     * @param object $data
     */
    public function __construct($data = null)
    {
        $this->source = $data;

        $this->locale = $data->locale ?? null;
        $this->timezone = $data->timezone ?? null;

        if (isset($data->interfaces)) {
            $this->interfaces = new MetaInterfaces($data->interfaces);
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
    public function isInterfaces(): bool
    {
        return $this->interfaces instanceof MetaInterfaces;
    }

    /**
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * @return string|null
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * @return MetaInterfaces|null
     */
    public function getInterfaces(): ?MetaInterfaces
    {
        return $this->interfaces;
    }
}
