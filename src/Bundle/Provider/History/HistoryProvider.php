<?php

namespace RusLan\SeamlessMessage\Bundle\Provider\History;

use RusLan\SeamlessMessage\Bundle\Doctrine\EntityManagerAwareInterface;
use RusLan\SeamlessMessage\Bundle\Doctrine\EntityManagerAwareTrait;

class HistoryProvider implements EntityManagerAwareInterface
{
    use EntityManagerAwareTrait;

    /**
     * @param object $object
     * @return static
     */
    public function update($object)
    {
        $this->getEntityManager()->persist($object);
        return $this;
    }

    /**
     * @return static
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
        return $this;
    }
}
