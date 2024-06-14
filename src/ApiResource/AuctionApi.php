<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Auction;
use App\Entity\AuctionsBids;
use App\Entity\AuctionsCategories;
use App\Entity\Courier;
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use App\Validator\IsValidOwner;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    shortName: 'Auction',
    description: 'Opis dla programisty: Pojedyńcza aukcja w serwisie.',
    operations: [
        new Get(
            openapiContext: [
                'summary' => 'Pobierz pojedynczy zasób aukcji / Retrieve single Auction resource',
                'description' => 'Ten punkt końcowy umożliwia pobranie pojedynczego zasobu aukcji.'
            ]
        ),
        new GetCollection(
            openapiContext: [
                'summary' => 'Pobierz kolekcję zasobów aukcji / Retrieve the collection of Auction resources',
                'description' => 'Ten punkt końcowy umożliwia pobranie kolekcji zasobów aukcji.'
            ],
            order: ['dateTimeAdd' => 'DESC']
        ),
        new Post(
            openapiContext: [
                'summary' => 'Zapisz nowy zasób aukcji / Save new Auction resource',
                'description' => "Zapisz nową aukcję. Większość pół powinna być znana. Pola takie jak: \n
                                    auctionCategoryId -należy pobrać z kategorii dostępnych pod endpointem '/api/auctions_categories'. 
                                    title - tytuł max 80 znaków
                                    productState - przyjmuje wartości tylko 'new' albo 'used'
                                    ISBN - EAN
                                    description - opis 
                                    isCompany - true albo false
                                    quantity - ilość, liczba pełna
                                    quantityType - przyjmuje wartości tylko 'szt.', 'kg.', 'l.'
                                    auctionDuration - liczba w dniach min. 1 dzień 
                                    auctionBuyNowPrice - cena sprzedaży 'kup teraz'. UWAGA! 1zł to 100! Kwota brutto w groszach.
                                    auctionBidStartPrice - jeżeli ma być aukcja, to ustaw cene startową większą niż 0 . UWAGA! 1zł to 100! Kwota brutto w groszach.
                                    courier - IRI kuriera które można pobrać z endpoint Courier
                                    courierPrePaymentPrice - kwota jaką kupujący będzie musiał zapłacić za przesyłkę towaru 'z góry'
                                    courierAfterDeliveryPaymentPrice - kwota jaką kupujący będzie musiał zapłacić za przesyłkę towaru 'za pobraniem'
                                 ",
            ],
            security: 'is_granted("ROLE_USER")'
        ),
//        new Patch(
//            security: 'is_granted("EDIT", object)',
//        ),
        new Delete(
            openapiContext: [
                'summary' => 'Usuń pojedyńczą aukce / Delete Auction resources',
                'description' => 'Ten punkt końcowy umożliwia usunięcie pojedyńczej aukcji przez użytkownika który ją stworzył.'
            ],
            security: 'is_granted("ROLE_USER")',
        )
    ],
    paginationItemsPerPage: 20,
    provider: EntityToDtoStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: Auction::class),
)]
class AuctionApi
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;

    #[NotBlank]
    public ?AuctionsCategoriesApi $auctionCategory = null;

    #[NotBlank]
    public ?string $title = null;

    #[NotBlank]
    public ?string $productState = null;

    #[NotBlank]
    public ?string $isbn = null;

    #[NotBlank]
    public ?string $description = null;

    public ?bool $isCompany = null;

    #[NotBlank]
    #[GreaterThanOrEqual(1)]
    public ?int $quantity = null;

    #[NotBlank]
    public ?string $quantityType = null;

    #[NotBlank]
    #[GreaterThanOrEqual(1)]
    public ?int $auctionDuration = null;

    #[NotBlank]
    #[GreaterThanOrEqual(1)]
    public ?int $auctionBuyNowPrice = null;

    #[NotBlank]
    #[GreaterThanOrEqual(0)]
    public ?int $auctionBidStartPrice = null;

    #[NotBlank]
    public ?CourierApi $courier = null;

    #[NotBlank]
    public ?int $courierPrePaymentPrice = null;

    #[NotBlank]
    public ?int $courierAfterDeliveryPaymentPrice = null;

    #[NotBlank]
    public ?\DateTimeImmutable $dateTimeAdd = null;

    #[NotBlank]
    public ?\DateTimeImmutable $dateTimeModify = null;

    #[NotBlank]
    public ?\DateTimeImmutable $dateTimeDeleted = null;

    public function __toString()
    {
        return (string)$this->id;
    }


}
