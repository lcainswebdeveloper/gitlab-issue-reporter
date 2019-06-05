<?php

namespace Gitlab\Client;

class Guzzle
{
    protected $client;
    protected $headers;
    protected $status;
    protected $accessToken;
    protected $projectId;
    protected $assigneeId;
    protected $baseUri;
    protected $apiResponse;

    public function __construct($baseUri, $accessToken)
    {
        $this->baseUri = $baseUri;
        $this->setAccessToken($accessToken);
        $this->client = new \GuzzleHttp\Client();
    }

    protected function setRequestData(array $headers = [])
    {
        $allHeaders = $headers + [
            'Private-Token' => $this->getAccessToken(),
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        $this->addHeaders($allHeaders);

        return[
            'base_uri' => $this->baseUri,
            'headers' => $this->getHeaders(),
        ];
    }

    public function get(string $url, array $headers = [])
    {
        try {
            $sentHeaders = $this->setRequestData($headers);

            $response = $this->client->get($url, $sentHeaders);
            $this->setStatus($response->getStatusCode());
            $this->setApiResponse(json_decode($response->getBody()));

            return $this;
        } catch (\Exception $e) {
            $this->setStatus($e->getCode());
            $this->setApiResponse([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return $this;
        }
    }

    public function post(string $url, array $postData = [], array $headers = [])
    {
        try {
            $body = ['body' => json_encode($postData)];
            $sentHeaders = $this->setRequestData($headers);
            $client = new \GuzzleHttp\Client($sentHeaders);
            $response = $client->post($url, $body);
            $this->setStatus($response->getStatusCode());
            $this->setApiResponse(json_decode($response->getBody()));

            return $this;
        } catch (\Exception $e) {
            $this->setStatus($e->getCode());
            $this->setApiResponse([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'errors' => json_decode($e->getResponse()->getBody()->getContents()),
                'code' => $e->getCode(),
            ]);

            return $this;
        }
    }

    public function delete(string $url, array $headers = [])
    {
        try {
            $sentHeaders = $this->setRequestData($headers);

            $response = $this->client->delete($url, $sentHeaders);
            $this->setStatus($response->getStatusCode());
            $this->setApiResponse(json_decode($response->getBody()));

            return $this;
        } catch (\Exception $e) {
            $this->setStatus($e->getCode());
            $this->setApiResponse([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return $this;
        }
    }

    /**
     * Get the value of accessToken.
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the value of accessToken.
     *
     * @return self
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get the value of status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status.
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Add new header to headers array.
     */
    public function addHeaders(array $headers = [])
    {
        foreach ($headers as $key => $header) {
            $this->addHeader($key, $header);
        }

        return $this;
    }

    /**
     * Add new header to headers array.
     */
    public function addHeader($key, $header)
    {
        $this->headers[$key] = $header;

        return $this;
    }

    /**
     * Get the value of headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the value of apiResponse.
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Set the value of apiResponse.
     *
     * @return self
     */
    public function setApiResponse($apiResponse)
    {
        $response = [
            'data' => $apiResponse,
            'code' => $this->getStatus(),
        ];
        $this->apiResponse = (object) $response;

        return $this;
    }
}
