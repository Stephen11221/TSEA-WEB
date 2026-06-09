<?php
namespace App\Services;

class CardSplitter
{
    public function split(string $title, ?string $text, int $limit = 200): array
    {
        $text = trim(preg_replace('/\s+/', ' ', $text ?? ''));

        if ($text === '') {
            return [];
        }

        $words = explode(' ', $text);
        $chunks = array_chunk($words, $limit);

        return array_map(function ($chunk) use ($title) {
            return [
                'title' => $title,
                'text' => implode(' ', $chunk),
            ];
        }, $chunks);
    }
}