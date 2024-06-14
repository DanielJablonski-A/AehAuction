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
use App\Entity\Courier;
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use App\Validator\IsValidOwner;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    shortName: 'Courier',
    operations: [
//        new Get(
//            openapiContext: [
//                'summary' => 'Pobierz pojedyńczego kuriera / Retrieve single Courier resource',
//                'description' => ''
//            ]
//        ),
        new GetCollection(
            openapiContext: [
                'summary' => 'Pobierz listę dostępnych kurierów / Retrieve Courier list resource',
                'description' => 'Ten punkt końcowy umożliwia pobranie listy obsługiwanych kurierów na naszej platformie. Podanie id kuriera przy wystawianiu
                                    aukcji jest obowiązkowe.'
            ]
        ),
        new Post(
            openapiContext: [
                'summary' => 'Dodawanie nowego kuriera / Adds new courier',
                'description' => 'Ten punkt końcowy umożliwia dodanie kuriera przez pracownika naszego serwisu.'
            ],
            //security: 'is_granted("ROLE_ADMIN")'
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
    stateOptions: new Options(entityClass: Courier::class),
)]
class CourierApi
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;

    #[NotBlank]
    public ?string $courierName = null;

    public bool $isActive = false;
    public ?int $sortOrder = null;
    public ?\DateTimeImmutable $dateTimeAdd = null;
    public ?\DateTimeImmutable $dateTimeModify = null;

    public function __toString()
    {
        return (string)$this->id;
    }
}
