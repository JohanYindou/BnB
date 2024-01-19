<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Equipement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Set admin
        $admin = new User();
        $admin->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname('Admin')
            ->setLastname('Martin')
            ->setPassword('$2y$13$wqXiXE8U6QhYtIRJFedLA.MkNVmDzn89jVz5CBYENUOwHfAlyYNG2')
            ->setImage('/images/default-2.jpg')
            ->setAddress($faker->address)
            ->setCity($faker->city)
            ->setCountry($faker->country);
        $manager->persist($admin);

        // Set hosts
        $hosts = [];
        for ($i = 0; $i < 8; $i++) {
            $host = new User();
            $host->setEmail('host' . $i . '@host.fr')
                ->setRoles(['ROLE_HOST'])
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setBirthyear($faker->numberBetween(1980, 2000))
                ->setPassword('$2y$13$wqXiXE8U6QhYtIRJFedLA.MkNVmDzn89jVz5CBYENUOwHfAlyYNG2')
                ->setImage(rand(0, 1) ? '/images/default-1.jpg' : '/images/default-2.jpg')
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setCountry($faker->country);
            $manager->persist($host);
            array_push($hosts, $host);
        }

        // Set equipements
        $equipements = ['wifi', 'tv', 'climatiseur', 'lave-linge', 'lave-vaisselle', 'piscine', 'jacuzzi', 'parking'];
        $equipementArray = [];
        for ($i = 0; $i < count($equipements); $i++) {
            $equipement = new Equipement();
            $equipement->setName($equipements[$i]);
            $manager->persist($equipement);
            array_push($equipementArray, $equipement);
        }

        // Set rooms
        $cities = ['paris', 'las vegas', 'kyoto', 'sydney', 'hong kong'];
        for ($i = 0; $i < 100; $i++) {

            $room = new Room();
            $room->setTitle($faker->text(50))
                ->setCity($faker->randomElement($cities))
                ->addEquipement($faker->randomElement($equipementArray))
                ->addEquipement($faker->randomElement($equipementArray))
                ->setDescription($faker->paragraphs(3, true))
                ->setHost($faker->randomElement($hosts))
                ->setPrice($faker->numberBetween(150, 1500));

            // Add favorites to admin
            if ($i < 10) {
                $admin->addFavorite($room);
            }

            // Set users with favorites
            if ($i > 70) {
                $user = new User();
                $user->setEmail('user' . $i . '@user.fr')
                    ->setRoles(['ROLE_USER'])
                    ->setFirstname($faker->firstName)
                    ->setLastname($faker->lastName)
                    ->setBirthyear($faker->numberBetween(1980, 2000))
                    ->setPassword('$2y$13$wqXiXE8U6QhYtIRJFedLA.MkNVmDzn89jVz5CBYENUOwHfAlyYNG2')
                    ->setImage(rand(0, 1) ? '/images/default-1.jpg' : '/images/default-2.jpg')
                    ->setAddress($faker->address)
                    ->setCity($faker->city)
                    ->setCountry($faker->country)
                    ->addFavorite($room);
                $manager->persist($user);

                // Set Reviews
                $review = new Review();
                $reviewDate = $faker->dateTimeBetween('-4 months');
                $review->setRating(mt_rand(1, 5))
                    ->setTitle($faker->word(3, true))
                    ->setComment($faker->text(255))
                    ->setTraveler($user)
                    ->setRooms($room)
                    ->setRating($faker->numberBetween(1, 5))
                    ->setCreatedAt($reviewDate);

                $manager->persist($review);
            }
            $manager->persist($room);
        }

        // Flush
        $manager->flush();
    }
}
