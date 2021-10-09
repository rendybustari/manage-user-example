<?php

namespace App\Services;

use App\Repositories\GeneralRepository;

class GeneralService
{

    private $generalRepository;

    public function __construct(
        GeneralRepository $generalRepository
    ) {
        $this->generalRepository = $generalRepository;
    }

    public function provinces()
    {
        return $this->generalRepository->provinces();
    }
}
