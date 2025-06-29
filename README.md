# GeminiAI PHP Library

A lightweight PHP library for interacting with Google's Gemini AI API.

## Features

- Simple integration with Gemini 1.5 Flash model
- Command-line chat interface
- Conversation history management
- Easy to implement in any PHP project

## Installation

Clone this repository:

```bash
git clone https://github.com/alwanandri2712/geminiAi-php.git
```

## Usage

### Basic Example

```php
<?php
require_once 'gemini-ai.php';

$gemini = new GeminiAPI();
$response = $gemini->generateContent('Tell me about PHP');
$result = json_decode($response, true);

if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    echo $result['candidates'][0]['content']['parts'][0]['text'];
}
```

### Interactive Chat

Run the included chat interface:

```bash
php gemini-ai.php
```

## Configuration

Set your API key and system prompt in the `config.php` file:

```php
return [
    'api_key' => 'your_api_key',
    'system_prompt' => "Lu asisten AI dari AllOne Cyber Tech. Gaya ngobrol lu santai, gaul, tapi tetep sopan. Inget ya"
];
```

## Requirements

- PHP 7.0 or higher
- cURL extension enabled

## License

MIT

## Author

Alwan Putra Andriansyah