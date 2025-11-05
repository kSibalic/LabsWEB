<?php
class SimpleParser {
    public static function findArticles($html) {
        $articles = [];

        // Regex za <article>...</article>
        preg_match_all('/<article[^>]*>(.*?)<\/article>/is', $html, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $articleContent) {
                $articles[] = $articleContent;
            }
        }

        return $articles;
    }

    public static function findFirstLink($content) {
        // Regex za <a href="...">tekst</a>
        if (preg_match('/<a\s+[^>]*href=["\'](.*?)["\'][^>]*>(.*?)<\/a>/is', $content, $match)) {
            return [
                'href' => trim($match[1]),
                'text' => trim(strip_tags($match[2]))
            ];
        }

        return ['href' => '', 'text' => ''];
    }

    public static function findOIB($content) {
        if (preg_match('/\b(\d{11})\b/', $content, $match)) {
            return $match[1];
        }
        return '';
    }

    public static function findFirstParagraph($html) {
        if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $html, $match)) {
            return trim(strip_tags($match[1]));
        }
        return '';
    }

    public static function cleanText($text) {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
}