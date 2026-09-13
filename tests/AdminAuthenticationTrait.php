<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

trait AdminAuthenticationTrait
{
    private function loginAsAdmin(KernelBrowser $client): User
    {
        $container = static::getContainer();
        $entityManager = $container->get('doctrine')->getManager();
        $hasher = $container->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail(sprintf('admin-test-%s@example.com', uniqid()));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($hasher->hashPassword($user, 'test-password'));

        $entityManager->persist($user);
        $entityManager->flush();

        $client->loginUser($user);

        return $user;
    }
}
