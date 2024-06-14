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
use App\State\EntityClassDtoStateProcessor;
use App\State\EntityToDtoStateProvider;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    operations: [
        new Get(
            openapiContext: [
            'summary' => 'Pobierz informacje o użytkowniku / Get user info',
            'description' => 'Ten punkt końcowy umożliwia pobranie informacji o użytkowniku po username.'
        ]),
//        new GetCollection(),
        new Post(
            openapiContext: [
                'summary' => 'Zapisuje nowego użytkownika / Save new user info',
                'description' => 'Ten punkt końcowy umożliwia zapisanie informacji o użytkowniku.'
            ],
            security: 'is_granted("PUBLIC_ACCESS")',
            validationContext: ['groups' => ['Default', 'postValidation']],
        ),
        new Patch(
            openapiContext: [
                'summary' => 'Edytuje użytkownika / Edit user info',
                'description' => 'Ten punkt końcowy umożliwia edytownie informacji o użytkowniku.'
            ],
            security: 'is_granted("ROLE_USER_EDIT")'
        ),
        new Delete(
            openapiContext: [
                'summary' => 'Kasuje użytkownika / Delete user info',
                'description' => 'Ten punkt końcowy umożliwia usunięcie informacji o użytkowniku.'
            ],
        ),
    ],
    paginationItemsPerPage: 5,
    security: 'is_granted("ROLE_USER")',
    provider: EntityToDtoStateProvider::class,
    processor: EntityClassDtoStateProcessor::class,
    stateOptions: new Options(entityClass: User::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'username' => 'partial',
])]

class UserApi
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\NotBlank]
    public ?string $username = null;

    /**
     * The plaintext password when being set or changed.
     */
    #[ApiProperty(readable: false)]
    #[Assert\NotBlank(groups: ['postValidation'])]
    public ?string $password = null;
}
