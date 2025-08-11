<?php

namespace SimpleLLM\Providers;

class GeminiProvider extends AbstractProvider
{
    protected function getDefaultModel(): string
    {
        return 'gemini-1.5-flash';
    }

    protected function getBaseUrl(): string
    {
        return 'https://generativelanguage.googleapis.com/v1beta/models/' . $this->model . ':generateContent?key=' . $this->apiKey;
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }

    protected function formatRequest(string $message): array
    {
        return [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $message
                        ]
                    ]
                ]
            ]
        ];
    }

    protected function extractResponse(array $response): string
    {
        return $response['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }
}