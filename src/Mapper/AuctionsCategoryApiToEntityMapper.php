<?php

namespace App\Mapper;

use App\ApiResource\AuctionsCategoriesApi;
use App\Entity\AuctionsCategories;
use App\Entity\User;
use App\Repository\AuctionsCategoriesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionsCategoriesApi::class, to: AuctionsCategories::class)]
class AuctionsCategoryApiToEntityMapper implements MapperInterface
{
    public function __construct(
        private AuctionsCategoriesRepository $repository,
        private Security $security,
        private MicroMapperInterface $microMapper,
    )
    {

    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof AuctionsCategoriesApi);

        $entity = $dto->id ? $this->repository->find($dto->id) : new AuctionsCategories($dto->categoryName);
        if (!$entity) {
            throw new \Exception('Auctions AuctionsCategoriesApi not found');
        }

        return $entity;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $dto = $from;
        $entity = $to;
        assert($dto instanceof AuctionsCategoriesApi);
        assert($entity instanceof AuctionsCategories);

        $entity->setCategoryName($dto->categoryName);
        $entity->setDateTimeModify(new \DateTimeImmutable());
        $entity->setIsActive($dto->isActive);

        return $entity;
    }
}
