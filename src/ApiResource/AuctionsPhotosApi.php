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
use App\Entity\AuctionsBids;
use App\Entity\AuctionsPhotos;
use App\Entity\User;
use App\State\AuctionsBidsStateProcessor;
use App\State\AuctionsBidsStateProvider;
use App\State\AuctionsPhotosStateProvider;
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use App\Validator\IsValidOwner;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    shortName: 'AuctionsPhotos',
    operations: [
//        new Get(
//            openapiContext: [
//                'summary' => 'Pobierz zdjęcia przedmiotu / Retrieve single auction photo',
//                'description' => ''
//            ]
//        ),
        new GetCollection(
            openapiContext: [
                'summary' => 'Pobierz zdjęcia przedmiotu / Retrieve the collection of auction photos',
                'description' => 'Ten punkt końcowy umożliwia pobranie kolekcji zdjęć pojedyńczej aukcji. {auctionId} to id aukcji. W jednym zapytaniu można pobrać zdjęcia tylko jednej aukcji.'
            ]
        ),
        new Post(
            openapiContext: [
                'summary' => 'Dodaj zdjęcia do swojej aukcji / Add photos to your listing',
                'description' => "Zalogowany użytkownik może dodać zdjęcia do swojej aukcji \n
                                    auctionId - IRI aukcji z endpointu Auction \n
                                    photoUrl - url zdjecia \n
                                    isDeleted - czy zdjęcie ma się nie pokazywać \n
                                    dateTimeAdd - dodawana automatycznie, nie zmieniać \n
                                    dateTimeDeleted - jeżeli usuniesz to tutaj bedzie data
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
    provider: AuctionsPhotosStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: AuctionsPhotos::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'auction' => 'exact',
])]
class AuctionsPhotosApi
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;

    #[Assert\NotBlank(message: 'auction jest wymagany')]
    public ?AuctionApi $auction = null;

    #[NotBlank]
    public ?string $photoUrl = null;

    public ?bool $isDeleted = null;

    #[NotBlank]
    public ?\DateTimeImmutable $dateTimeAdd = null;

    public ?\DateTimeImmutable $dateTimeDeleted = null;

}
