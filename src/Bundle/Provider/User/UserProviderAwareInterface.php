<?php

namespace RusLan\SeamlessMessage\Bundle\Provider\User;

interface UserProviderAwareInterface
{
    public function getUserProvider(): ?UserProvider;

    /**
     * @param UserProvider|null $userProvider
     * @return static
     */
    public function setUserProvider(?UserProvider $userProvider = null);
}
