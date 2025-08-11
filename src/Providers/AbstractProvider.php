<?php

namespace SimpleLLM\Providers;

use GuzzleHttp\Client;
use SimpleLLM\Exceptions\LLMException;

abstract class AbstractProvider
{
    protected Client $httpClient;
    protected string $apiKey;
    protected string $model;

    public function __construct(string $apiKey, string $model = null)
    {
        $this->apiKey = $apiKey;
        $this->model = $model ?? $this->getDefaultModel();
        $this->httpClient = new Client();
    }

    abstract protected function getDefaultModel(): string;
    
    abstract protected function getBaseUrl(): string;
    
    abstract protected function getHeaders(): array;
    
    abstract protected function formatRequest(string $message): array;
    
    abstract protected function extractResponse(array $response): string;

    public function chat(string $message): string
    {
        try {
            $response = $this->httpClient->post($this->getBaseUrl(), [
                'headers' => $this->getHeaders(),
                'json' => $this->formatRequest($message)
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() !== 200) {
                throw new LLMException("API Error: " . ($data['error']['message'] ?? 'Unknown error'));
            }

            return $this->extractResponse($data);
            
        } catch (\Exception $e) {
            throw new LLMException("Request failed: " . $e->getMessage());
        }
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}