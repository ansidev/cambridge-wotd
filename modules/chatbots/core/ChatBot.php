<?php
namespace Modules\ChatBots\Core;

class ChatBot
{
    private $id;
    private $apiVersion;
    private $baseUri;


    /**
     * Class Constructor
     * @param    $id
     * @param    $apiVersion
     * @param    $baseUri
     */
    public function __construct($id, $apiVersion, $baseUri)
    {
        $this->id = $id;
        $this->apiVersion = $apiVersion;
        $this->baseUri = $baseUri;
    }

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of apiVersion.
     *
     * @return mixed
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Gets the value of baseUri.
     *
     * @return mixed
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }
}
