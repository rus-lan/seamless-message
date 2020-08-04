<?php

namespace RusLan\SeamlessMessage\Bundle\Model\Messages\DTO;

interface ContentInterface
{
    /**
     * @param object $data
     */
    public function __construct($data = null);

    /**
     * @return string
     */
    public function getType(): string;
}
