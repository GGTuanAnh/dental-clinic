<img
  src="{{ $src }}"
  @if($srcset) srcset="{{ $srcset }}" @endif
  @if($sizes) sizes="{{ $sizes }}" @endif
  alt="{{ $alt }}"
  loading="{{ $loading }}"
  {{ $attributes }}
>
