<?php

namespace App\Jobs\GenerateCatalog;

class GeneratePointsJob extends AbstractJob
{
    public function handle(): void
    {
        $f = 1 / 0; // симулюємо помилку

        parent::handle();
    }
}
