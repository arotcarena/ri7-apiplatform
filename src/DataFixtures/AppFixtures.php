<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {

    }

    public function load(ObjectManager $manager): void
    {
        $user = new User;
        $user->setEmail('test@email.com')
            ->setPassword(
                $this->hasher->hashPassword($user, 'password')
            )
            ->setRoles(['ROLE_USER'])
            ;
        $manager->persist($user);

        for($i=0 ; $i < 8; $i++)
        {
            $book = (new Book)
                    ->setAuthor('author' . $i)
                    ->setTitle('title' . $i)
                    ->setYear('202' . $i)
                    ;
            $manager->persist($book);
        }

        $manager->flush();
    }
}
