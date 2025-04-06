<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ClassGroupFactory;
use App\Factory\ProjectFactory;
use App\Factory\StudentFactory;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ClassGroupFactory::createMany(4);
        ProjectFactory::createMany(6);
        StudentFactory::createMany(32);
        UserFactory::createMany(3);

        $manager->flush();
    }
}
