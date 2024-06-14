<?php

namespace App\Mapper;

use App\ApiResource\AuctionApi;
use App\ApiResource\AuctionsBidsApi;
use App\ApiResource\UserApi;
use App\Entity\Auction;
use App\Entity\AuctionsBids;
use App\Helper\TaxCalculator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionsBids::class, to: AuctionsBidsApi::class)]
class AuctionsBidsEntityToApiMapper implements MapperInterface
{
    public function __construct(
        private MicroMapperInterface $microMapper,
        private Security             $security,
    )
    {
    }

    public function load(object $from, string $toClass, array $context): object
    {
        //dd($from, $toClass, $context);

        $entity = $from;
        assert($entity instanceof AuctionsBids);

        $dto = new AuctionsBidsApi();
        $dto->id = $entity->getId();

        return $dto;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof AuctionsBids);
        assert($dto instanceof AuctionsBidsApi);

        $dto->auction = $this->microMapper->map($entity->getAuction(), AuctionApi::class);
        $dto->currentBidPrice = TaxCalculator::nettoDatabaseToBrutto($entity->getCurrentBidPriceNet(), 23);
        $dto->dateTimeAdd = $entity->getDateTimeAdd();

        $dto->owner = $this->microMapper->map($entity->getOwner(), UserApi::class, [
            MicroMapperInterface::MAX_DEPTH => 0,
        ]);

        return $dto;
    }
}
