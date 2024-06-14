<?php

namespace App\Mapper;

use App\ApiResource\CourierApi;
use App\Entity\Courier;
use Symfony\Bundle\SecurityBundle\Security;
use Symfonycasts\MicroMapper\AsMapper;
use Symfonycasts\MicroMapper\MapperInterface;
use Symfonycasts\MicroMapper\MicroMapperInterface;

#[AsMapper(from: Courier::class, to: CourierApi::class)]
class CourierEntityToApiMapper implements MapperInterface
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
        assert($entity instanceof Courier);

        $dto = new CourierApi();
        $dto->id = $entity->getId();

        return $dto;
    }

    public function populate(object $from, object $to, array $context): object
    {
        $entity = $from;
        $dto = $to;
        assert($entity instanceof Courier);
        assert($dto instanceof CourierApi);

        $dto->courierName = $entity->getCourierName();
        $dto->isActive = $entity->getIsActive();
        $dto->sortOrder = $entity->getSortOrder();
        $dto->dateTimeAdd = $entity->getDateTimeAdd();
        $dto->dateTimeModify = $entity->getDateTimeModify();

        return $dto;
    }
}
