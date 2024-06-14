<?php

namespace App\Mapper;

use App\ApiResource\AuctionsCategoriesApi;
use App\Entity\AuctionsCategories;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionsCategories::class, to: AuctionsCategoriesApi::class)]
class AuctionsCategoryEntityToApiMapper implements MapperInterface
{
    public function __construct(
        private MicroMapperInterface $microMapper,
        private Security $security,
    )
    {
    }

    public function load(object $from, string $toClass, array $context): object
    {
        $entity = $from;
        assert($entity instanceof AuctionsCategories);

        $dto = new AuctionsCategoriesApi();
        $dto->id = $entity->getId();

        return $dto;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof AuctionsCategories);
        assert($dto instanceof AuctionsCategoriesApi);

        $dto->categoryName = $entity->getCategoryName();
        $dto->isActive = $entity->getIsActive();

        return $dto;
    }
}
