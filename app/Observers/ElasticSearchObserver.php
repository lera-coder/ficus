<?php

namespace App\Observers;

use Elasticsearch\Client;

class ElasticSearchObserver
{
    /**
     * @var Client
     */
    private $elasticsearch;

    /**
     * ElasticSearchObserver constructor.
     * @param Client $elasticsearch
     */
    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @param $model
     */
    public function saved($model)
    {
        $this->elasticsearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    /**
     * @param $model
     */
    public function deleted($model)
    {
        $this->elasticsearch->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
