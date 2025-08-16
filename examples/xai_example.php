<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SimpleLLM\LLMClient;
use SimpleLLM\Exceptions\LLMException;

try {
    // Initialize the client
    $llm = new LLMClient();
    
    echo "=== xAI Grok Example ===\n\n";
    
    // Using Grok with the default model (grok-beta)
    $response = $llm->useProvider('xai')
                   ->chat('What makes you unique as an AI assistant?');
    
    echo "Grok's response:\n";
    echo $response . "\n\n";
    
    // You can also pass the API key directly if not using .env
    // $llm->useProvider('xai', null, 'your-xai-api-key-here')
    //     ->chat('Hello Grok!');
    
    // Get current model
    echo "Current model: " . $llm->getModel() . "\n\n";
    
} catch (LLMException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}