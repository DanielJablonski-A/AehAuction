<?php

namespace App\Factory;

use App\Entity\Auction;
use App\Repository\AuctionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Auction>
 *
 * @method        Auction|Proxy                     create(array|callable $attributes = [])
 * @method static Auction|Proxy                     createOne(array $attributes = [])
 * @method static Auction|Proxy                     find(object|array|mixed $criteria)
 * @method static Auction|Proxy                     findOrCreate(array $attributes)
 * @method static Auction|Proxy                     first(string $sortedField = 'id')
 * @method static Auction|Proxy                     last(string $sortedField = 'id')
 * @method static Auction|Proxy                     random(array $attributes = [])
 * @method static Auction|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AuctionRepository|RepositoryProxy repository()
 * @method static Auction[]|Proxy[]                 all()
 * @method static Auction[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Auction[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Auction[]|Proxy[]                 findBy(array $attributes)
 * @method static Auction[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Auction[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AuctionFactory extends ModelFactory
{
    const PRODUCTSTATE = [
        'new',
        'used'
    ];

    const QUANTITYTYPE = [
        'szt.',
        'kg.',
        'l.'
    ];
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'auctionBidStartPriceNet' => self::faker()->numberBetween(0, 1),
            'auctionBuyNowPriceNet' => self::faker()->randomNumber(),
            'auctionCategory' => AuctionsCategoriesFactory::random(),
            'auctionDuration' => self::faker()->numberBetween(1,10),
            'courierAfterDeliveryPaymentPriceNet' => self::faker()->randomNumber(),
            'courier' => CourierFactory::random(),
            'courierPrePaymentPriceNet' => self::faker()->randomNumber(),
            'description' => self::faker()->text(),
            'isCompany' => self::faker()->boolean(),
            'isbn' => self::faker()->randomNumber(),
            'owner' => UserFactory::random(),
            'productState' => self::faker()->randomElement(self::PRODUCTSTATE),
            'quantity' => self::faker()->randomNumber(),
            'quantityType' => self::faker()->randomElement(self::QUANTITYTYPE),
            'title' => self::faker()->text(80),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Auction $auction): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Auction::class;
    }
}
