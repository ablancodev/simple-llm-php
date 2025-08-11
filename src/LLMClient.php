<?php

namespace SimpleLLM;

use Dotenv\Dotenv;
use SimpleLLM\Providers\AbstractProvider;
use SimpleLLM\Providers\OpenAIProvider;
use SimpleLLM\Providers\AnthropicProvider;
use SimpleLLM\Providers\GeminiProvider;
use SimpleLLM\Exceptions\LLMException;

class LLMClient
{
    const PROVIDER_OPENAI = 'openai';
    const PROVIDER_ANTHROPIC = 'anthropic';
    const PROVIDER_GEMINI = 'gemini';

    private AbstractProvider $provider;

    public function __construct(?string $envPath = null)
    {
        $this->loadEnvironment($envPath);
    }

    public function useProvider(string $providerName, ?string $model = null): self
    {
        switch (strtolower($providerName)) {
            case self::PROVIDER_OPENAI:
                $apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
                $defaultModel = $_ENV['OPENAI_MODEL'] ?? 'gpt-4o-mini';
                $this->provider = new OpenAIProvider($apiKey, $model ?? $defaultModel);
                break;

            case self::PROVIDER_ANTHROPIC:
                $apiKey = $_ENV['ANTHROPIC_API_KEY'] ?? null;
                $defaultModel = $_ENV['ANTHROPIC_MODEL'] ?? 'claude-3-5-sonnet-20241022';
                $this->provider = new AnthropicProvider($apiKey, $model ?? $defaultModel);
                break;

            case self::PROVIDER_GEMINI:
                $apiKey = $_ENV['GEMINI_API_KEY'] ?? null;
                $defaultModel = $_ENV['GEMINI_MODEL'] ?? 'gemini-1.5-flash';
                $this->provider = new GeminiProvider($apiKey, $model ?? $defaultModel);
                break;

            default:
                throw new LLMException("Provider '{$providerName}' not supported");
        }

        if (!$apiKey) {
            throw new LLMException("API key not found for provider '{$providerName}'");
        }

        return $this;
    }

    public function chat(string $message): string
    {
        if (!isset($this->provider)) {
            throw new LLMException("No provider selected. Use useProvider() first");
        }

        return $this->provider->chat($message);
    }

    public function setModel(string $model): self
    {
        if (!isset($this->provider)) {
            throw new LLMException("No provider selected. Use useProvider() first");
        }

        $this->provider->setModel($model);
        return $this;
    }

    public function getModel(): string
    {
        if (!isset($this->provider)) {
            throw new LLMException("No provider selected");
        }

        return $this->provider->getModel();
    }

    private function loadEnvironment(?string $path = null): void
    {
        $envFile = $path ?? getcwd() . '/.env';
        
        if (file_exists($envFile)) {
            $dotenv = Dotenv::createImmutable(dirname($envFile));
            $dotenv->load();
        }
    }

    public static function getSupportedProviders(): array
    {
        return [
            self::PROVIDER_OPENAI => 'OpenAI (ChatGPT)',
            self::PROVIDER_ANTHROPIC => 'Anthropic (Claude)',
            self::PROVIDER_GEMINI => 'Google (Gemini)'
        ];
    }
}