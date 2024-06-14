<?php

namespace App\Mapper;

use App\ApiResource\AuctionsPhotosApi;
use App\Entity\AuctionsPhotos;
use App\Entity\User;
use App\Repository\AuctionRepository;
use App\Repository\AuctionsPhotosRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionsPhotosApi::class, to: AuctionsPhotos::class)]
class AuctionsPhotosApiToEntityMapper implements MapperInterface
{
    public function __construct(
        private AuctionRepository      $auctionRepository,
        private AuctionsPhotosRepository $repository,
        private Security $security,
        private MicroMapperInterface $microMapper,
    )
    {

    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof AuctionsPhotosApi);

        $auction = $this->auctionRepository->find($dto->auction);
        if (!$auction) {
            throw new \Exception('Wybrana aukcja nie istnieje / Auction not found');
        }

        $entity = $dto->id ? $this->repository->find($dto->id) : new AuctionsPhotos($auction, $dto->photoUrl);
        if (!$entity) {
            throw new \Exception('Auctions AuctionsPhotos (eex2) not found');
        }

        return $entity;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $dto = $from;
        $entity = $to;
        assert($dto instanceof AuctionsPhotosApi);
        assert($entity instanceof AuctionsPhotos);

        $entity->setDateTimeDeleted($dto->dateTimeDeleted);
        $entity->setIsDeleted($dto->isDeleted);

        return $entity;
    }
}
