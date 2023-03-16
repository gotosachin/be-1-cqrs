<?php

namespace App\Shared\Domain\Bus;

interface QueryBus
{
    public function ask(Query $query): Response|null;
}
