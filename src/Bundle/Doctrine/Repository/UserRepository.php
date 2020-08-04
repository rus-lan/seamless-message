<?php


namespace RusLan\SeamlessMessage\Bundle\Doctrine\Repository;

use RusLan\SeamlessMessage\Bundle\Model\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(User::class));
    }

    /**
     * @param int|string|null $accountUid
     * @param string $botName
     * @return User|null|object
     */
    public function findByAccount($accountUid = null, string $botName = ''): ?User
    {
        return $accountUid ? $this->findOneBy([
            'accountUid' => $accountUid,
            'botName' => $botName,
        ]) : null;
    }
}
