<?php

namespace App\Mapper;

use App\ApiResource\AuctionApi;
use App\ApiResource\AuctionsCategoriesApi;
use App\ApiResource\CourierApi;
use App\ApiResource\UserApi;
use App\Entity\Auction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: Auction::class, to: AuctionApi::class)]
class AuctionEntityToApiMapper implements MapperInterface
{
    public function __construct(
        private MicroMapperInterface $microMapper,
        private Security             $security,
    )
    {
    }

    public function load(object $from, string $toClass, array $context): object
    {
        $entity = $from;
        assert($entity instanceof Auction);

        $dto = new AuctionApi();
        $dto->id = $entity->getId();

        return $dto;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof Auction);
        assert($dto instanceof AuctionApi);

        //$dto->auctionCategory = $entity->getAuctionCategory();
        $dto->auctionCategory = $this->microMapper->map($entity->getAuctionCategory(), AuctionsCategoriesApi::class);
        $dto->title = $entity->getTitle();
        $dto->productState = $entity->getProductState();
        $dto->isbn = $entity->getIsbn();
        $dto->description = $entity->getDescription();
        $dto->isCompany = $entity->getIsCompany();
        $dto->quantity = $entity->getQuantity();
        $dto->quantityType = $entity->getQuantityType();
        $dto->auctionDuration = $entity->getAuctionDuration();
        $dto->auctionBuyNowPrice = $entity->getAuctionBuyNowPriceNet();
        $dto->auctionBidStartPrice = $entity->getAuctionBidStartPriceNet();
        $dto->courier = $this->microMapper->map($entity->getCourier(), CourierApi::class);
        $dto->courierPrePaymentPrice = $entity->getCourierPrePaymentPriceNet();
        $dto->courierAfterDeliveryPaymentPrice = $entity->getCourierAfterDeliveryPaymentPriceNet();
        $dto->dateTimeAdd = $entity->getDateTimeAdd();
        $dto->dateTimeModify = $entity->getDateTimeModify();
        $dto->dateTimeDeleted = $entity->getDateTimeDeleted();
        //$dto->isMine = $this->security->getUser() && $this->security->getUser() === $entity->getOwner();

        return $dto;
    }
}
