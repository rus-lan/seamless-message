<?php


namespace RusLan\SeamlessMessage\Bundle\Provider\User;

use RusLan\SeamlessMessage\Bundle\Doctrine\EntityManagerAwareInterface;
use RusLan\SeamlessMessage\Bundle\Doctrine\EntityManagerAwareTrait;
use RusLan\SeamlessMessage\Bundle\Doctrine\Type\SourceTypeEnum;
use RusLan\SeamlessMessage\Bundle\Model\Messages\DTO\Telegram\MessageFrom;
use RusLan\SeamlessMessage\Bundle\Model\User\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, EntityManagerAwareInterface
{
    use EntityManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername(string $username)
    {
        throw new UsernameNotFoundException(sprintf('User "%s" is not found.', $username));
    }

    /**
     * @param MessageFrom $data
     * @param string|null $botName
     * @return User
     */
    public function createUserToTelegram(MessageFrom $data, ?string $botName): User
    {
        return (new User())
            ->setAccountUid($data->getId())
            ->setUsername($data->getUsername())
            ->setLanguage($data->getLanguageCode())
            ->setBot($data->getIsBot())
            ->setType(SourceTypeEnum::source__telegram)
            ->setBotName($botName)
        ;
    }

    public function getUserToTelegram(MessageFrom $data, ?string $botName): User
    {
        if (($user = $this->getEntityManager()->getRepository(User::class)->findByAccount($data->getId(), $botName)) && ($user instanceof User)) {
            // empty
        } else {
            $user = $this->createUserToTelegram($data, $botName);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        if ($user->getId() === null) {
            $this->persist($user);
        } elseif (($update = $this->getUser($user->getId())) && ($update instanceof User)) {
            $update->setMessages($user->getMessages());
        }

        $this->flush();

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;
    }

    /**
     * @param int $id
     * @return object|null|User
     */
    public function getUser(int $id)
    {
        return $this->getEntityManager()->getRepository(User::class)->find($id);
    }

    /**
     * @param object $object
     * @return static
     */
    public function persist($object)
    {
        $this->getEntityManager()->persist($object);
        return $this;
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }
}
