<?php

namespace FiveamCode\LaravelNotionApi\Entities\Properties;

use FiveamCode\LaravelNotionApi\Entities\Contracts\Modifiable;

class Status extends Property implements Modifiable
{
    public static function value(string $name): Status
    {
        $statusProperty = new Status();
        return $statusProperty;
    }

    protected function fillFromRaw(): void
    {
        $this->content = $this->responseData['status'];
    }

    public function getName()
    {
        return $this->content['name'];
    }

    public function getContent()
    {
        return $this->content;
    }
}