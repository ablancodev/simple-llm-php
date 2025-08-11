<?php

namespace SimpleLLM\Providers;

class AnthropicProvider extends AbstractProvider
{
    protected function getDefaultModel(): string
    {
        return 'claude-3-5-sonnet-20241022';
    }

    protected function getBaseUrl(): string
    {
        return 'https://api.anthropic.com/v1/messages';
    }

    protected function getHeaders(): array
    {
        return [
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'anthropic-version' => '2023-06-01'
        ];
    }

    protected function formatRequest(string $message): array
    {
        return [
            'model' => $this->model,
            'max_tokens' => 1000,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ]
        ];
    }

    protected function extractResponse(array $response): string
    {
        return $response['content'][0]['text'] ?? '';
    }
}