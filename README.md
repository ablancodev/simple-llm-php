# Simple LLM PHP Client

A simple PHP library to interact with major LLM providers: OpenAI (ChatGPT), Anthropic (Claude), and Google (Gemini).

## Features

- ✅ Simple and clean API
- ✅ Support for multiple LLM providers
- ✅ Easy model switching
- ✅ Secure API key management
- ✅ Production-ready with multiple configuration options
- ✅ Zero dependencies besides HTTP client

## Installation

```bash
composer require ablancodev/simple-llm-php
```

## Configuration

The library offers three ways to configure API keys:

### Option 1: Using .env file (Development)

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

⚠️ **SECURITY WARNING**: Never commit `.env` files to version control or upload them to public directories.

### Option 2: Environment Variables (Production)

Configure your API keys as environment variables in your server (Apache, Nginx, etc.) and access them using `getenv()`.

### Option 3: Direct Configuration

Pass API keys directly when initializing providers (useful for dynamic configurations).

## Basic Usage

### Option 1: Using .env file (Development)

```php
<?php
require_once 'vendor/autoload.php';

use SimpleLLM\LLMClient;

$llm = new LLMClient();

// Use OpenAI
$response = $llm->useProvider('openai')
               ->chat('Hello, how are you?');
```

### Option 2: Manual configuration (Production)

```php
<?php
require_once 'vendor/autoload.php';

use SimpleLLM\LLMClient;

// Pass configuration directly in the constructor
$llm = new LLMClient(null, [
    'api_keys' => [
        'openai' => getenv('OPENAI_API_KEY'),
        'anthropic' => getenv('ANTHROPIC_API_KEY'),
        'gemini' => getenv('GEMINI_API_KEY')
    ],
    'models' => [
        'openai' => 'gpt-4o-mini',
        'anthropic' => 'claude-3-5-sonnet-20241022',
        'gemini' => 'gemini-1.5-flash'
    ]
]);

$response = $llm->useProvider('openai')->chat('Hello!');
```

### Option 3: Pass API key directly

```php
// Pass API key directly when using a provider
$llm = new LLMClient();
$response = $llm->useProvider('openai', 'gpt-4o', 'your-api-key-here')
               ->chat('Hello, how are you?');
```

### Changing models dynamically

```php
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

```php
<?php
require_once 'vendor/autoload.php';

use SimpleLLM\LLMClient;
use SimpleLLM\Exceptions\LLMException;

try {
    // Initialize client
    $llm = new LLMClient();
    
    // Chat with different providers
    $openAIResponse = $llm->useProvider('openai')->chat('What is PHP?');
    $claudeResponse = $llm->useProvider('anthropic')->chat('Explain Laravel');
    $geminiResponse = $llm->useProvider('gemini')->chat('Best PHP practices');
    
    // Change model on the fly
    $llm->useProvider('openai')
        ->setModel('gpt-4o')
        ->chat('Write a complex algorithm');
        
} catch (LLMException $e) {
    echo "Error: " . $e->getMessage();
}
```

Check `examples/basic_usage.php` for more examples.

## Error Handling

The library throws `LLMException` for all errors. Always wrap your calls in try-catch blocks:

```php
try {
    $response = $llm->useProvider('openai')->chat('Hello');
} catch (LLMException $e) {
    // Handle API errors, missing keys, etc.
    echo "Error: " . $e->getMessage();
}
```

## Requirements

- PHP >= 7.4
- Composer
- API keys for the providers you want to use

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

MIT License - see LICENSE file for details.