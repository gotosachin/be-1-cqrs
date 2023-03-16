<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Domain\Bus\Query;
use App\Shared\Domain\Bus\QueryBus;
use App\Shared\Domain\Bus\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBusSymphonyMessenger implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param  Query  $query
     *
     * @return Response|null
     */
    public function ask(Query $query): Response|null
    {
        return $this->handleQuery($query);
    }
}
