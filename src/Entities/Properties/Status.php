<?php

namespace FiveamCode\LaravelNotionApi\Entities\Properties;

use FiveamCode\LaravelNotionApi\Entities\Contracts\Modifiable;
use FiveamCode\LaravelNotionApi\Entities\PropertyItems\StatusItem;
use FiveamCode\LaravelNotionApi\Exceptions\HandlingException;
use Illuminate\Support\Collection;

class Status extends Property implements Modifiable
{
    public static function value(string $name): Status
    {
        $statusProperty = new Status();
        return $statusProperty;
    }

    protected function fillFromRaw(): void
    {
        parent::fillFromRaw();

        if (empty($this->rawContent)) {
            $this->content = null;
            return;
        }

        if (! is_array($this->rawContent)) {
            throw HandlingException::instance('The property-type is status, however the raw data-structure does not reprecent this type. Please check the raw response-data.');
        }

        if (array_key_exists('options', $this->rawContent)) {
            $this->options = new Collection();
            foreach ($this->rawContent['options'] as $key => $item) {
                $this->options->add(new StatusItem($item));
            }
        } else {
            foreach ($this->rawContent as $key => $item) {
                $this->content = new StatusItem($this->rawContent);
            }
        }
    }

    public function getItem(): StatusItem
    {
        return $this->content;
    }

    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function getName()
    {
        return $this->content->getName();
    }

    public function getColor()
    {
        return $this->content->getColor();
    }
}