<?php

namespace App\DataFixtures;

use App\Domain\Blog\Model\Post;
use App\Domain\User\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $user = User::create($faker->userName, $faker->email);
        $manager->persist($user);
        $manager->flush();

        for ($i = 0; $i < 10; ++$i) {
            $post = Post::create($faker->text, $faker->realTextBetween(200, 5000), $user);
            $manager->persist($post);
        }
        $manager->flush();
    }
}
