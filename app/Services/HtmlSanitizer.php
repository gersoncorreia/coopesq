<?php

namespace App\Services;

class HtmlSanitizer
{
    /**
     * Sanitize HTML content by stripping dangerous tags and inline javascript event handlers.
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // 1. Remove dangerous executable tags and their inner content
        $dangerousTags = ['script', 'iframe', 'object', 'embed', 'applet', 'meta', 'link', 'style', 'base', 'form'];
        foreach ($dangerousTags as $tag) {
            $html = preg_replace('#<' . $tag . '[^>]*>.*?</' . $tag . '>#is', '', $html);
            $html = preg_replace('#<' . $tag . '[^>]*>#is', '', $html);
        }

        // 2. Remove inline javascript events (on* attributes like onerror, onload, onclick)
        $html = preg_replace('/(\s)on[a-zA-Z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i', '', $html);

        // 3. Remove javascript: pseudo-protocols in href and src attributes
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*(\2)/i', '$1="#"', $html);
        $html = preg_replace('/(href|src)\s*=\s*javascript:[^\s>]+/i', '$1="#"', $html);

        // 4. Remove data: text/html base64 XSS vectors
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*data:text\/html[^"\']*(\2)/i', '$1="#"', $html);

        return trim($html);
    }

    /**
     * Clean and validate URL, ensuring only safe protocols (http, https, mailto, tel, or anchor #) are permitted.
     */
    public static function cleanUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Relative anchor or path
        if (str_starts_with($url, '#') || str_starts_with($url, '/')) {
            return $url;
        }

        // Must start with safe protocol
        if (preg_match('/^(https?|mailto|tel):/i', $url)) {
            return $url;
        }

        return null;
    }
}
