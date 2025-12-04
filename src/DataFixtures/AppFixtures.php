<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cat;
use App\Entity\User;
use App\Entity\Task;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        $cats = [];
        for($i = 0; $i < 50; $i++){
            $cat = new Cat();
            $cat->setNameCat($faker->word());
            $manager->persist($cat);
            $cats[]=$cat;
        }

        $users=[];
        for($i = 0 ; $i<100 ; $i++){
            $user = new User();
            $user->setNameUser($faker->lastName())
                ->setFirstNameUser($faker->firstName())
                ->setLoginUser($faker->userName())
                ->setMdpUser($faker->password());
            $manager->persist($user);
            $users[]=$user;
        }

        for($i=0; $i<400; $i++){
            $task = new Task();
            $task->setNameTask($faker->words(3, true))
                ->setContentTask($faker->paragraph())
                ->setDateTask(new \DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s')))
                ->setUserTask($users[array_rand($users)])
                ->setCatTask($faker->randomElement($cats));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
