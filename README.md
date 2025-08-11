# Simple LLM PHP Client

A simple PHP library to interact with major LLM providers: OpenAI (ChatGPT), Anthropic (Claude), and Google (Gemini).

## Installation

```bash
composer require ablancodev/simple-llm-php
```

## Configuration

1. Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

2. Configure your API keys in the `.env` file:
```env
# OpenAI/ChatGPT
OPENAI_API_KEY=your-openai-api-key-here
OPENAI_MODEL=gpt-4o-mini

# Anthropic/Claude
ANTHROPIC_API_KEY=your-anthropic-api-key-here
ANTHROPIC_MODEL=claude-3-5-sonnet-20241022

# Google Gemini
GEMINI_API_KEY=your-gemini-api-key-here
GEMINI_MODEL=gemini-1.5-flash
```

## Basic Usage

```php
<?php
require_once 'vendor/autoload.php';

use SimpleLLM\LLMClient;

$llm = new LLMClient();

// Use OpenAI
$response = $llm->useProvider('openai')
               ->chat('Hello, how are you?');

// Use Claude
$response = $llm->useProvider('anthropic')
               ->chat('Explain what PHP is');

// Use Gemini
$response = $llm->useProvider('gemini')
               ->chat('What is the capital of Spain?');

// Change model dynamically
$llm->useProvider('openai')
    ->setModel('gpt-4o')
    ->chat('Complex question');
```

## Available Models

### OpenAI
- `gpt-4o`
- `gpt-4o-mini`
- `gpt-4-turbo`
- `gpt-3.5-turbo`

### Anthropic
- `claude-3-5-sonnet-20241022`
- `claude-3-5-haiku-20241022`
- `claude-3-opus-20240229`

### Google Gemini
- `gemini-1.5-pro`
- `gemini-1.5-flash`
- `gemini-1.0-pro`

## Complete Example

Check `examples/basic_usage.php` for a complete usage example.

## License

MIT