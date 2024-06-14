<?php

namespace App\Factory;

use App\Entity\AuctionsBids;
use App\Repository\AuctionsBidsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AuctionsBids>
 *
 * @method        AuctionsBids|Proxy                     create(array|callable $attributes = [])
 * @method static AuctionsBids|Proxy                     createOne(array $attributes = [])
 * @method static AuctionsBids|Proxy                     find(object|array|mixed $criteria)
 * @method static AuctionsBids|Proxy                     findOrCreate(array $attributes)
 * @method static AuctionsBids|Proxy                     first(string $sortedField = 'id')
 * @method static AuctionsBids|Proxy                     last(string $sortedField = 'id')
 * @method static AuctionsBids|Proxy                     random(array $attributes = [])
 * @method static AuctionsBids|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AuctionsBidsRepository|RepositoryProxy repository()
 * @method static AuctionsBids[]|Proxy[]                 all()
 * @method static AuctionsBids[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AuctionsBids[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AuctionsBids[]|Proxy[]                 findBy(array $attributes)
 * @method static AuctionsBids[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AuctionsBids[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AuctionsBidsFactory extends ModelFactory
{
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
            'auctionId' => self::faker()->randomNumber(),
            'currentBidPriceNet' => self::faker()->randomNumber(),
            'dateTimeAdd' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'owner' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AuctionsBids $auctionsBids): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AuctionsBids::class;
    }
}
