<?php

namespace App\Mapper;

use App\ApiResource\AuctionApi;
use App\ApiResource\AuctionsCategoriesApi;
use App\ApiResource\AuctionsPhotosApi;
use App\Entity\AuctionsCategories;
use App\Entity\AuctionsPhotos;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionsPhotos::class, to: AuctionsPhotosApi::class)]
class AuctionsPhotosEntityToApiMapper implements MapperInterface
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
        assert($entity instanceof AuctionsPhotos);

        $dto = new AuctionsPhotosApi();
        $dto->id = $entity->getId();

        return $dto;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof AuctionsPhotos);
        assert($dto instanceof AuctionsPhotosApi);

        $dto->auction = $this->microMapper->map($entity->getAuction(), AuctionApi::class);
        $dto->photoUrl = $entity->getPhotoUrl();
        $dto->isDeleted = $entity->isDeleted();
        $dto->dateTimeAdd = $entity->getDateTimeAdd();
        $dto->dateTimeDeleted = $entity->getDateTimeDeleted();

        return $dto;
    }
}
