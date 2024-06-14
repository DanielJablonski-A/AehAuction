<?php

namespace App\Mapper;

use App\ApiResource\CourierApi;
use App\Entity\Courier;
use App\Entity\User;
use App\Repository\CourierRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: CourierApi::class, to: Courier::class)]
class CourierApiToEntityMapper implements MapperInterface
{
    public function __construct(
        private CourierRepository $repository,
        private Security $security,
        private MicroMapperInterface $microMapper,
    )
    {

    }

    public function load(object $from, string $toClass, array $context): object
    {
        $dto = $from;
        assert($dto instanceof CourierApi);

        $entity = $dto->id ? $this->repository->find($dto->id) : new Courier($dto->courierName);
        if (!$entity) {
            throw new \Exception('Auctions CourierApi not found');
        }

        return $entity;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $dto = $from;
        $entity = $to;
        assert($dto instanceof CourierApi);
        assert($entity instanceof Courier);

        $entity->setIsActive($dto->isActive);
        $entity->setDateTimeModify($dto->dateTimeModify);
        $entity->setSortOrder($dto->sortOrder);

        return $entity;
    }
}
