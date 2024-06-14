<?php

namespace App\DataFixtures;

use App\Entity\Auction;
use App\Factory\ApiTokenFactory;
use App\Factory\AuctionFactory;
use App\Factory\AuctionsCategoriesFactory;
use App\Factory\AuctionsPhotosFactory;
use App\Factory\CourierFactory;
use App\Factory\UserFactory;
use App\Repository\AuctionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'admin@admin.pl',
            'password' => 'admin',
        ]);

        //AuctionsCategoriesFactory::createMany(30);

        UserFactory::createMany(10);

        CourierFactory::createMany(3);

        AuctionsCategoriesFactory::createMany(20);

        AuctionFactory::createMany(30, function () {
            return [
                'owner' => UserFactory::random(),
            ];
        });

        ApiTokenFactory::createMany(30, function () {
            return [
                'ownedBy' => UserFactory::random(),
            ];
        });

        AuctionsPhotosFactory::createMany(10);
    }
}
