<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

trait RepositoryAwareTrait
{
    /**
     * @var EntityRepository|null
     */
    protected $repository;

    public function getRepository(): ?EntityRepository
    {
        return $this->repository;
    }

    /**
     * @param EntityRepository|null $repository
     * @return static
     */
    public function setRepository(?EntityRepository $repository = null)
    {
        $this->repository = $repository;

        return $this;
    }
}
