<?php
/* #alwan Ganteng */

class GeminiAPI {
    private $api_key;
    private $url;
    private $systemPrompt;

    public function __construct() {
        $config = require_once 'config.php';
        $this->api_key = $config['api_key'];
        $this->systemPrompt = $config['system_prompt'];
        $this->url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $this->api_key;
    }

    public function generateContent($prompt, $conversation = []) {
        $contents = [
            [
                "role" => "user",
                "parts" => [
                    ["text" => $this->systemPrompt]
                ]
            ]
        ];

        foreach ($conversation as $message) {
            $contents[] = [
                "role" => $message['role'],
                "parts" => [
                    ["text" => $message['content']]
                ]
            ];
        }

        $contents[] = [
            "role" => "user",
            "parts" => [
                ["text" => $prompt]
            ]
        ];

        $data = ["contents" => $contents];

        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }
}

function startChat() {
    $gemini = new GeminiAPI();
    $conversation = [];

    echo "Selamat datang di Chat AI AllOne Cyber Tech! Ketik 'exit' untuk keluar.\n";

    while (true) {
        echo "Anda: ";
        $prompt = trim(fgets(STDIN));

        if (strtolower($prompt) === 'exit') {
            echo "Makasih udah ngobrol sama gue! Sampai ketemu lagi ya!\n";
            break;
        }

        try {
            $rawResponse = $gemini->generateContent($prompt, $conversation);
            $response = json_decode($rawResponse, true);

            if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
                $result = $response['candidates'][0]['content']['parts'][0]['text'];
                echo "AI: " . $result . "\n\n";

                // Simpan percakapan
                $conversation[] = ['role' => 'user', 'content' => $prompt];
                $conversation[] = ['role' => 'model', 'content' => $result];
            } else {
                echo "AI: Sori bro, gue nggak bisa ngasih respons yang valid sekarang.\n";
                echo "Detail error: " . $rawResponse . "\n\n";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}

// Mulai chat
startChat();