<?php

namespace App\Mapper;

use ApiPlatform\Api\IriConverterInterface;
use App\ApiResource\AuctionApi;
use App\ApiResource\AuctionsBidsApi;
use App\ApiResource\UserApi;
use App\Entity\Auction;
use App\Entity\AuctionsBids;
use App\Entity\User;
use App\Helper\MoneyHelper;
use App\Helper\TaxCalculator;
use App\Repository\AuctionRepository;
use App\Repository\AuctionsBidsRepository;
use App\Repository\AuctionsCategoriesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: AuctionsBidsApi::class, to: AuctionsBids::class)]
class AuctionsBidsApiToEntityMapper implements MapperInterface
{

    public function __construct(
        private AuctionRepository      $auctionRepository,
        private AuctionsBidsRepository $auctionsBidsRepository,
        private Security               $security,
        private MicroMapperInterface   $microMapper,
    )
    {

    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof AuctionsBidsApi);

        $auction = $this->auctionRepository->find($dto->auction);
        if (!$auction) {
            throw new \Exception('Wybrana aukcja nie istnieje / Auction not found');
        }

        $currentBidPriceBrutto = $dto->currentBidPrice;
        $currentBidPriceNet = TaxCalculator::bruttoToNetto($currentBidPriceBrutto, 23);

        if ($auction->getAuctionBidStartPriceNet() > 0) {
            // czyli to jest aukcja gdzie można licytować

            // sprawdzam czy kwota jaka chce dac uzytkownik jest wieksza od minimalnej ustawionej
            if ($auction->getAuctionBidStartPriceNet() > $currentBidPriceNet) {
                throw new \Exception('Kwota jaką chcesz zalicytować jest mniejsza od minimalnej. / The amount you want to bid is less than seller minimum.');
            }

            // sprawdzam ile jest najwiecej i czy kwoata bedzie przebita
            $maxBidNetto = $this->auctionsBidsRepository->getAuctionMaxBid($dto->auction->id);
            $maxBidBrutto = TaxCalculator::nettoDatabaseToBrutto($maxBidNetto, 23);
            if ($maxBidNetto > 0){
                // ludzie juz licytują
                if ($currentBidPriceBrutto <= $maxBidBrutto) {
                    throw new \Exception('Kwota jaką chcesz zalicytować jest mniejsza albo równa obecnej (' . $maxBidBrutto  . '). / The amount you want to bid is less than the current.');
                }

                if (!MoneyHelper::isGreaterThanByAtLeast100($currentBidPriceBrutto, $maxBidBrutto)) {
                    throw new \Exception('Kwota jaką chcesz zalicytować musi być większa od obecnej (' . $maxBidBrutto  . ') o minimum 100 (1zł). / The amount you want to bid must be 100 (1zł) more than current.');
                }

            }
        } else {
            throw new \Exception('Aukcja nie jest aukcją do licytacji. / The auction is not an auction for bidding.');
        }


        //dd($bids);

        return new AuctionsBids(
            $auction,
            $currentBidPriceNet,
            $this->security->getUser()
        );
    }

    public function populate(object $from, object $to, array $context): object
    {
        $dto = $from;
        $entity = $to;
        assert($dto instanceof AuctionsBidsApi);
        assert($entity instanceof AuctionsBids);

        return $entity;
    }
}
