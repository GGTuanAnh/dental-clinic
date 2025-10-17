@php($last = count($items)-1)
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb small mb-0">
    @foreach($items as $i => $b)
      <li class="breadcrumb-item {{ $i===$last ? 'active fw-semibold' : '' }}" @if($i===$last) aria-current="page" @endif>
        @if($i !== $last && !empty($b['url']))
          <a href="{{ $b['url'] }}" class="text-decoration-none">@if(!empty($b['icon']))<i class="bi bi-{{ $b['icon'] }} me-1"></i>@endif{{ $b['label'] }}</a>
        @else
          @if(!empty($b['icon']))<i class="bi bi-{{ $b['icon'] }} me-1"></i>@endif{{ $b['label'] }}
        @endif
      </li>
    @endforeach
  </ol>
</nav>
