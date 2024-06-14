<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Auction;
use App\Entity\AuctionsBids;
use App\Entity\User;
use App\State\AuctionsBidsStateProcessor;
use App\State\AuctionsBidsStateProvider;
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use App\Validator\IsValidOwner;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    shortName: 'AuctionsBids',
    operations: [
//        new Get(
//            openapiContext: [
//                'summary' => 'Pobierz historię licytacji przedmiotu / Retrieve single auction bid history',
//                'description' => 'Ten punkt końcowy umożliwia pobranie historii pojedyńczej aukcji.'
//            ]
//        ),
        new GetCollection(
            openapiContext: [
                'summary' => 'Pobierz historię licytacji przedmiotu / Retrieve the collection of auction bid history',
                'description' => "Ten punkt końcowy umożliwia pobranie kolekcji licytacji pojedyńczej aukcji. {auctionId} to id aukcji. W jednym zapytaniu można pobrać tylko jednej historię aukcji. \n 
                                    currentBidPrice - UWAGA! 1zł to 100! Kwota brutto w groszach.
                "
            ]
        ),
        new Post(
            openapiContext: [
                'summary' => 'Zalicytuj w aukcji z licytacją / Bid in a bidding auction',
                'description' => "Zalogowany użytkownik może zalicytować w wybranej sobie aukcji z włączoną licytacją \n
                                    currentBidPrice - ile chcesz zapłacić, musi być więcej niż inni'. UWAGA! 1zł to 100! Kwota brutto w groszach. \n
                                    auctionId - IRI aukcji z endpointu Auction \n
                                    dateTimeAdd - dodawana automatycznie, nie zmieniać
                "
            ],
            security: 'is_granted("ROLE_USER")'
        ),
//        new Patch(
//            security: 'is_granted("EDIT", object)',
//        ),
//        new Delete(
//            security: 'is_granted("ROLE_USER")',
//        )
    ],
    paginationItemsPerPage: 30,
    provider: AuctionsBidsStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: AuctionsBids::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'auction' => 'exact',
])]
class AuctionsBidsApi
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;

    #[NotBlank]
    #[GreaterThanOrEqual(1)]
    public ?int $currentBidPrice = null;

    #[NotBlank(message: 'auction jest wymagany')]
    public ?AuctionApi $auction = null;

    #[NotBlank]
    public ?\DateTimeImmutable $dateTimeAdd = null;

    #[IsValidOwner]
    public ?UserApi $owner = null;
}
