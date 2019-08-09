<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('ledilsonfilho')
            ->setPassword('$2y$13$tqbEVn1/bfIhtfo.t0qFcOm9knv5N9SujbBz9KSTkw4BMnVhjU8K2');

        $manager->persist($user);
        $manager->flush();
    }
}
