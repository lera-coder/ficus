<?php


namespace App\Services\SearchService\AllSearchService;


class AllMySqlSearchService implements AllSearchServiceInterface
{

    public function search(string $query)
    {
        return collect();
    }
}