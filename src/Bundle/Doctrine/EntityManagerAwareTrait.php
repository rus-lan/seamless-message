<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerAwareTrait
{
    /**
     * @var EntityManagerInterface|null
     */
    protected $entityManager;

    public function getEntityManager(): ?EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface|null $entityManager
     * @return static
     */
    public function setEntityManager(?EntityManagerInterface $entityManager = null)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
