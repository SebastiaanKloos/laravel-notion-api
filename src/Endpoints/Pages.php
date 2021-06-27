<?php

namespace FiveamCode\LaravelNotionApi\Endpoints;

use FiveamCode\LaravelNotionApi\Entities\Collections\EntityCollection;
use FiveamCode\LaravelNotionApi\Entities\Collections\PageCollection;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Exceptions\NotionException;
use FiveamCode\LaravelNotionApi\Exceptions\HandlingException;
use FiveamCode\LaravelNotionApi\Notion;

/**
 * Class Pages
 * @package FiveamCode\LaravelNotionApi\Endpoints
 */
class Pages extends Endpoint implements EndpointInterface
{

    /**
     * Retrieve a page
     * url: https://api.notion.com/{version}/pages/{page_id}
     * notion-api-docs: https://developers.notion.com/reference/get-page
     *
     * @param string $pageId
     * @return Page
     * @throws HandlingException
     * @throws NotionException
     */
    public function find(string $pageId): Page
    {
        $response = $this->get(
            $this->url(Endpoint::PAGES . '/' . $pageId)
        );

        return new Page($response->json());
    }

    /**
     * @return Page
     */
    public function createInDatabase(string $parentId, Page $page): Page
    {
        $postData = [];
        $properties = [];

        foreach ($page->getProperties() as $property) {
            $properties[$property->getTitle()] = $property->getRawContent();
        }

        $postData["parent"] = ["database_id" => $parentId];
        $postData["properties"] = $properties;


        $response = $this
            ->post(
                $this->url(Endpoint::PAGES),
                $postData
            )
            ->json();

        return new Page($response);
    }

    /**
     * @return Page
     */
    public function createInPage(string $parentId, Page $page): Page
    {
        $postData = [];
        $properties = [];

        foreach ($page->getProperties() as $property) {
            $properties[$property->getTitle()] = $property->getRawContent();
        }

        $postData["parent"] = ["page_id" => $parentId];
        $postData["properties"] = $properties;


        $response = $this
            ->post(
                $this->url(Endpoint::PAGES),
                $postData
            )
            ->json();

        return new Page($response);
    }

    /**
     * Return all pages possible.
     *
     * @return EntityCollection
     * @throws HandlingException
     * @throws NotionException
     */
    public function all(): EntityCollection
    {
        return $this->notion->search()->onlyPages()->query();
    }

    /**
     * @return array
     * @throws HandlingException
     */
    public function update(Page $page): Page
    {
        $postData = [];
        $properties = [];

        foreach ($page->getProperties() as $property) {
            $properties[$property->getTitle()] = $property->getRawContent();
        }

        $postData["properties"] = $properties;

        $response = $this
            ->patch(
                $this->url(Endpoint::PAGES . "/" . $page->getId()),
                $postData
            )
            ->json();

        return new Page($response);
    }
}
