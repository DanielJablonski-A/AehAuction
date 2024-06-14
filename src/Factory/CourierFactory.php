<?php

namespace App\Factory;

use App\Entity\Courier;
use App\Repository\CourierRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Courier>
 *
 * @method        Courier|Proxy                     create(array|callable $attributes = [])
 * @method static Courier|Proxy                     createOne(array $attributes = [])
 * @method static Courier|Proxy                     find(object|array|mixed $criteria)
 * @method static Courier|Proxy                     findOrCreate(array $attributes)
 * @method static Courier|Proxy                     first(string $sortedField = 'id')
 * @method static Courier|Proxy                     last(string $sortedField = 'id')
 * @method static Courier|Proxy                     random(array $attributes = [])
 * @method static Courier|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CourierRepository|RepositoryProxy repository()
 * @method static Courier[]|Proxy[]                 all()
 * @method static Courier[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Courier[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Courier[]|Proxy[]                 findBy(array $attributes)
 * @method static Courier[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Courier[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CourierFactory extends ModelFactory
{

    const COURIERS = [
        'DHL',
        'DPD',
        'GLS',

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
            'courierName' => self::faker()->randomElement(self::COURIERS),
            'isActive' => self::faker()->boolean(),
            'sortOrder' => self::faker()->numberBetween(1,3),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Courier $courier): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Courier::class;
    }
}
