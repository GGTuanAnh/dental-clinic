<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MediaImg extends Component
{
    public string $type;
    /** @var int|string */
    public $id;
    public ?int $width;
    public ?int $height;
    public ?string $fit;
    public ?string $format;
    public ?int $quality;
    public ?string $version;
    public bool $retina;
    public ?string $sizes;
    public string $alt;
    public string $loading;

    public string $src;
    public ?string $srcset;

    public function __construct(
        string $type,
        $id,
        ?int $width = null,
        ?int $height = null,
        ?string $fit = 'cover',
        ?string $format = 'webp',
        ?int $quality = null,
        ?string $version = null,
        bool $retina = true,
        ?string $sizes = null,
        string $alt = '',
        string $loading = 'lazy'
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
        $this->fit = $fit;
        $this->format = $format;
        $this->quality = $quality;
        $this->version = $version;
        $this->retina = $retina;
        $this->sizes = $sizes;
        $this->alt = $alt;
        $this->loading = $loading;

        $this->src = $this->buildUrl(1);
        $this->srcset = $this->retina ? $this->buildSrcset() : null;
    }

    private function buildUrl(int $dpr = 1): string
    {
        $params = [];
        if ($this->width) $params['w'] = $this->width;
        if ($this->height) $params['h'] = $this->height;
        if ($this->fit) $params['fit'] = $this->fit;
        if ($dpr !== 1) $params['dpr'] = $dpr;
        if ($this->format) $params['f'] = $this->format;
        if ($this->quality) $params['q'] = $this->quality;
        if ($this->version) $params['v'] = $this->version;

        $qs = http_build_query($params);
        return "/media/{$this->type}/{$this->id}" . ($qs ? ("?" . $qs) : '');
    }

    private function buildSrcset(): string
    {
        // Density descriptor 1x, 2x
        $one = $this->buildUrl(1) . ' 1x';
        $two = $this->buildUrl(2) . ' 2x';
        return $one . ', ' . $two;
    }

    public function render(): View
    {
        return view('components.media-img');
    }
}
