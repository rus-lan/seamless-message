<?php

namespace RusLan\SeamlessMessage\Bundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

interface EntityManagerAwareInterface
{
    public function getEntityManager(): ?EntityManagerInterface;

    /**
     * @param EntityManagerInterface|null $entityManager
     * @return static
     */
    public function setEntityManager(?EntityManagerInterface $entityManager = null);
}
