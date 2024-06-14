<?php

namespace App\Mapper;

use App\ApiResource\AuctionApi;
use App\Entity\Auction;
use App\Entity\User;
use App\Repository\AuctionRepository;
use App\Repository\AuctionsCategoriesRepository;
use App\Repository\CourierRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionApi::class, to: Auction::class)]
class AuctionApiToEntityMapper implements MapperInterface
{
    public function __construct(
        private AuctionRepository            $auctionRepository,
        private AuctionsCategoriesRepository $auctionsCategoriesRepository,
        private CourierRepository            $courierRepository,
        private Security                     $security,
        private MicroMapperInterface         $microMapper,
    )
    {

    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof AuctionApi);

        $category = $this->auctionsCategoriesRepository->find($dto->auctionCategory);
        if (!$category) {
            throw new \Exception('Kategoria przedmiotu nie istnieje / Auction category not found');
        }

        if ($dto->id) {
            $entity = $this->auctionRepository->find($dto->id);
        } else {
            $entity = new Auction(
                $this->security->getUser(),
                $category,
                $dto->auctionBidStartPrice,
                $dto->auctionDuration,
                $dto->isCompany,
                $dto->productState
            );
        }

        if (!$entity) {
            throw new \Exception('Aukcja nie istnieje / Auction not found');
        }

        return $entity;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $dto = $from;
        $entity = $to;
        assert($dto instanceof AuctionApi);
        assert($entity instanceof Auction);

//        if ($dto->owner) {
//            $entity->setOwner($this->microMapper->map($dto->owner, User::class, [
//                MicroMapperInterface::MAX_DEPTH => 0,
//            ]));
//        } else {
//            $entity->setOwner($this->security->getUser());
//        }


        $courier = $this->courierRepository->find($dto->courier);

        //$entity->setOwner($this->security->getUser());
        $entity->setTitle($dto->title);
        //$entity->setProductState($dto->productState);
        $entity->setIsbn($dto->isbn);
        $entity->setDescription($dto->description);
        //$entity->setIsCompany($dto->isCompany);
        $entity->setQuantity($dto->quantity);
        $entity->setQuantityType($dto->quantityType);
        //$entity->setAuctionDuration($dto->auctionDuration);
        $entity->setAuctionBuyNowPriceNet($dto->auctionBuyNowPrice);
        //$entity->setAuctionBidStartPriceNet();
        //$entity->setAuctionCategoryId($dto->auctionCategoryId);
        $entity->setCourier($courier);
        $entity->setCourierPrePaymentPriceNet($dto->courierPrePaymentPrice);
        $entity->setCourierAfterDeliveryPaymentPriceNet($dto->courierAfterDeliveryPaymentPrice);

        return $entity;
    }
}
