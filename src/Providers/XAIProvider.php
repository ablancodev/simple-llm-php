<?php

namespace SimpleLLM\Providers;

class XAIProvider extends AbstractProvider
{
    protected function getDefaultModel(): string
    {
        return 'grok-beta';
    }

    protected function getBaseUrl(): string
    {
        return 'https://api.x.ai/v1/chat/completions';
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ];
    }

    protected function formatRequest(string $message): array
    {
        return [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'max_tokens' => 1000,
            'temperature' => 0.7
        ];
    }

    protected function extractResponse(array $response): string
    {
        return $response['choices'][0]['message']['content'] ?? '';
    }
}