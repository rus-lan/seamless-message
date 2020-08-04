<?php

namespace RusLan\SeamlessMessage\Bundle\Provider\User;

trait UserProviderAwareTrait
{
    /**
     * @var UserProvider|null
     */
    protected $userProvider;

    public function getUserProvider(): ?UserProvider
    {
        return $this->userProvider;
    }

    /**
     * @param UserProvider|null $userProvider
     * @return static
     */
    public function setUserProvider(?UserProvider $userProvider = null)
    {
        $this->userProvider = $userProvider;

        return $this;
    }
}
