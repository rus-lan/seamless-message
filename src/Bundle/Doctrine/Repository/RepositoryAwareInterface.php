<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

interface RepositoryAwareInterface
{
    public function getRepository(): ?EntityRepository;

    /**
     * @param EntityRepository|null $repository
     * @return static
     */
    public function setRepository(?EntityRepository $repository = null);
}
