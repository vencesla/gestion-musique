<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPassword;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface){
        $this->userPassword = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        for($i = 0; $i < 20; $i++){
            $sexe = mt_rand(0,1);
            if($sexe == 0){
                $type = "men";
            }else{
                $type = "women";
            }
            $user = new User();
            $user->setNom($faker->lastName())
                    ->setPrenom($faker->firstName())
                    ->setEmail($faker->email())
                    ->setAvatar('https://randomuser.me/api/portraits/med/'.$type."/". $i .".jpg")
                    ->setSexe($sexe)
                    ->setIsVerified(true)
                    ->setPassword( 
                        $this->userPassword->hashPassword(
                            $user,
                            "test1234"
                        )
                    );

            $manager->persist($user);
        }

        $admin = new User();
            $admin->setNom("admin")
                    ->setPrenom("Stéphane")
                    ->setEmail("admin@gmail.com")
                    ->setAvatar("https://randomuser.me/api/portraits/med/men/36.jpg")
                    ->setSexe($sexe)
                    ->setRoles(['ROLE_ADMIN'])
                    ->setIsVerified(true)
                    ->setPassword( 
                        $this->userPassword->hashPassword(
                            $admin,
                            "admintest"
                        )
                    );

            $manager->persist($admin);
        $manager->flush();
    }
}
