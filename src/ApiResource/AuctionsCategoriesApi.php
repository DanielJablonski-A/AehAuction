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
use App\Entity\AuctionsCategories;
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use App\Validator\IsValidOwner;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    shortName: 'AuctionsCategories',
    operations: [
//        new Get(),
        new GetCollection(
            openapiContext: [
                'summary' => 'Pobierz dostępne kategorie dla swojego produktu / Retrieve the collection of auction categories',
                'description' => 'Ten punkt końcowy umożliwia pobranie kolekcji dostępnych kategorii dla aukcji. {auctionId} to id aukcji.'
            ]
        ),
        new Post(
            openapiContext: [
                'summary' => 'Dodawanie nowej kategorii sprzedażowej w serwisie. / Adding a new sales category on the website.',
                'description' => "Pracownik naszego serwisu może dodać nowe kategorie \n
                                    categoryName - nazwa kategori \n
                                    isActive - czy ma być aktywna \n
                "
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
//        new Patch(
//          //  security: 'is_granted("EDIT", object)',
//        ),
//        new Delete(
//            security: 'is_granted("ROLE_ADMIN")',
//        )
    ],
    paginationItemsPerPage: 30,
    provider: EntityToDtoStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: AuctionsCategories::class),
)]
class AuctionsCategoriesApi
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;

    #[NotBlank]
    public ?string $categoryName = null;

    // Object is null ONLY during deserialization: so this allows isPublished
    // to be writable in ALL cases (which is ok because the operations are secured).
    // During serialization, object will always be a Api, so our
    // voter is called.
    #[ApiProperty(security: 'object === null or is_granted("EDIT", object)')]
    public bool $isActive = false;

    public function __toString()
    {
        return (string)$this->id;
    }
}
