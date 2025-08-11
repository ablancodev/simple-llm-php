<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SimpleLLM\LLMClient;
use SimpleLLM\Exceptions\LLMException;

try {
    $llm = new LLMClient();

    echo "=== Probando OpenAI (ChatGPT) ===\n";
    $response = $llm->useProvider('openai', 'gpt-4o-mini')
                   ->chat('Hola, ¿cómo estás? Responde brevemente.');
    echo "Respuesta: {$response}\n\n";

    echo "=== Probando Claude ===\n";
    $response = $llm->useProvider('anthropic', 'claude-3-5-sonnet-20241022')
                   ->chat('Explica qué es PHP en una línea.');
    echo "Respuesta: {$response}\n\n";

    echo "=== Probando Gemini ===\n";
    $response = $llm->useProvider('gemini', 'gemini-1.5-flash')
                   ->chat('¿Cuál es la capital de España?');
    echo "Respuesta: {$response}\n\n";

    echo "=== Cambiando modelo dinámicamente ===\n";
    $response = $llm->useProvider('openai')
                   ->setModel('gpt-4o')
                   ->chat('Cuenta hasta 3.');
    echo "Modelo actual: " . $llm->getModel() . "\n";
    echo "Respuesta: {$response}\n\n";

    echo "=== Proveedores soportados ===\n";
    foreach (LLMClient::getSupportedProviders() as $key => $name) {
        echo "- {$key}: {$name}\n";
    }

} catch (LLMException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}