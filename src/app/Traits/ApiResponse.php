<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var string
     */
    protected string $apiVersion;

    /**
     * setApiVersion
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * constructor
     */
    public function __construct()
    {
        $this->setApiVersion(config('backbone.api_version'));
    }

    /**
     * getModel
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * setModel
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * getApiVersion
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * setApiVersion
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param string $apiVersion
     */
    public function setApiVersion(string $apiVersion): void
    {
        $this->apiVersion = $apiVersion;
    }
}
