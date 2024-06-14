<?php

namespace App\Factory;

use App\Entity\AuctionsPhotos;
use App\Repository\AuctionsPhotosRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AuctionsPhotos>
 *
 * @method        AuctionsPhotos|Proxy                     create(array|callable $attributes = [])
 * @method static AuctionsPhotos|Proxy                     createOne(array $attributes = [])
 * @method static AuctionsPhotos|Proxy                     find(object|array|mixed $criteria)
 * @method static AuctionsPhotos|Proxy                     findOrCreate(array $attributes)
 * @method static AuctionsPhotos|Proxy                     first(string $sortedField = 'id')
 * @method static AuctionsPhotos|Proxy                     last(string $sortedField = 'id')
 * @method static AuctionsPhotos|Proxy                     random(array $attributes = [])
 * @method static AuctionsPhotos|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AuctionsPhotosRepository|RepositoryProxy repository()
 * @method static AuctionsPhotos[]|Proxy[]                 all()
 * @method static AuctionsPhotos[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AuctionsPhotos[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AuctionsPhotos[]|Proxy[]                 findBy(array $attributes)
 * @method static AuctionsPhotos[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AuctionsPhotos[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AuctionsPhotosFactory extends ModelFactory
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
            'auction' => AuctionFactory::new(),
            'isDeleted' => self::faker()->boolean(),
            'photoUrl' => self::faker()->imageUrl(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AuctionsPhotos $auctionsPhotos): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AuctionsPhotos::class;
    }
}
