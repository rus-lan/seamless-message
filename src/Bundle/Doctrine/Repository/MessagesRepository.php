<?php


namespace RusLan\SeamlessMessage\Bundle\Doctrine\Repository;

use RusLan\SeamlessMessage\Bundle\Model\Messages\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MessagesRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(Log::class));
    }
}
