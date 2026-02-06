<?php

namespace GazmendS\BLN;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Ideogram
{
    private Client $client;

    private function __construct(private string $apiKey, private string $version = 'v1')
    {
        $this->client = new Client([
            'base_uri' => 'https://api.ideogram.ai/'.$this->version.'/ideogram-v3/',
            'headers' => [
                'Api-Key' => $this->apiKey,
            ],
        ]);
    }

    public static function make(string $apiKey): self
    {
        return new self($apiKey);
    }

    public function generateImage(string $prompt, array $parameters = [], bool $transparent = false): array
    {
        $defaults = [
            'aspect_ratio' => '1x1',
            'rendering_speed' => 'TURBO',
            'style_type' => 'AUTO',
        ];

        $merged = array_merge($defaults, $parameters);

        $multipart = [['name' => 'prompt', 'contents' => $prompt]];
        foreach ($merged as $name => $contents) {
            $multipart[] = ['name' => $name, 'contents' => $contents];
        }

        $endpoint = $transparent ? 'generate-transparent' : 'generate';

        try {
            $response = $this->client->post($endpoint, ['multipart' => $multipart]);
            $body = json_decode((string) $response->getBody(), true);

            return [
                'success' => true,
                'status' => $response->getStatusCode(),
                'data' => isset($body['data'][0]) ? $body['data'][0] : null,
                'error' => $body['error'] ?? null,
            ];
        } catch (ClientException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);

            return [
                'success' => false,
                'status' => $e->getResponse()->getStatusCode(),
                'data' => $body['data'] ?? null,
                'error' => $body['error'] ?? $e->getMessage(),
            ];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'status' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500,
                'data' => null,
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 500,
                'data' => null,
                'error' => $e->getMessage(),
            ];
        }
    }
}
