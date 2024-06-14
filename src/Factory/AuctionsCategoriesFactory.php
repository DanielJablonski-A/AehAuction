<?php

namespace App\Factory;

use App\Entity\AuctionsCategories;
use App\Repository\AuctionsCategoriesRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AuctionsCategories>
 *
 * @method        AuctionsCategories|Proxy                     create(array|callable $attributes = [])
 * @method static AuctionsCategories|Proxy                     createOne(array $attributes = [])
 * @method static AuctionsCategories|Proxy                     find(object|array|mixed $criteria)
 * @method static AuctionsCategories|Proxy                     findOrCreate(array $attributes)
 * @method static AuctionsCategories|Proxy                     first(string $sortedField = 'id')
 * @method static AuctionsCategories|Proxy                     last(string $sortedField = 'id')
 * @method static AuctionsCategories|Proxy                     random(array $attributes = [])
 * @method static AuctionsCategories|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AuctionsCategoriesRepository|RepositoryProxy repository()
 * @method static AuctionsCategories[]|Proxy[]                 all()
 * @method static AuctionsCategories[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AuctionsCategories[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AuctionsCategories[]|Proxy[]                 findBy(array $attributes)
 * @method static AuctionsCategories[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AuctionsCategories[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AuctionsCategoriesFactory extends ModelFactory
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
            'categoryName' => "Kategoria " . self::faker()->text(20),
            'dateTimeAdd' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'dateTimeModify' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'isActive' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AuctionsCategories $auctionsCategories): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AuctionsCategories::class;
    }
}
