<?php

namespace FiveamCode\LaravelNotionApi\Entities\PropertyItems;

use FiveamCode\LaravelNotionApi\Entities\Entity;
use FiveamCode\LaravelNotionApi\Exceptions\HandlingException;
use Illuminate\Support\Arr;

class StatusItem extends Entity
{
    protected string $color;

    protected string $name;

    protected function setResponseData(array $responseData): void
    {
        if (! Arr::exists($responseData, 'id')) {
            throw HandlingException::instance('invalid json-array: no id provided');
        }
        $this->responseData = $responseData;
        $this->fillFromRaw();
    }

    protected function fillFromRaw(): void
    {
        $this->fillId();
        $this->fillName();
        $this->fillColor();
    }

    protected function fillName(): void
    {
        if (Arr::exists($this->responseData, 'name')) {
            $this->name = $this->responseData['name'];
        }
    }

    protected function fillColor(): void
    {
        if (Arr::exists($this->responseData, 'color')) {
            $this->color = $this->responseData['color'];
        }
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}