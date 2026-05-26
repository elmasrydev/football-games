<?php

namespace App\Services;

class SEOService
{
    protected $data = [];

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function get($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function getAll()
    {
        return $this->data;
    }

    public function generateTags()
    {
        $locale = app()->getLocale();
        $title = $this->get('title', __('Games Hub'));
        $description = $this->get('description', __('Experience the best online games on Gamesiano. Play now!'));
        $url = request()->fullUrl();
        $image = $this->get('image', asset('images/og-image.png'));

        $tags = [
            'title' => "{$title} - GAMESIANO",
            'description' => $description,
            'canonical' => $this->get('canonical', $url),
            'og_title' => $this->get('og_title', $title),
            'og_description' => $this->get('og_description', $description),
            'og_url' => $url,
            'og_image' => $image,
            'og_type' => $this->get('og_type', 'website'),
            'twitter_card' => $this->get('twitter_card', 'summary_large_image'),
        ];

        return $tags;
    }

    public function getHreflangs()
    {
        $currentUrl = request()->url();
        $locales = ['en', 'ar'];
        $hreflangs = [];

        foreach ($locales as $locale) {
            $hreflangs[$locale] = $this->getLocalizedUrl($locale);
        }

        return $hreflangs;
    }

    protected function getLocalizedUrl($locale)
    {
        $route = request()->route();
        if (!$route) return url($locale);

        $parameters = $route->parameters();
        $parameters['locale'] = $locale;

        return route($route->getName(), $parameters);
    }
}
