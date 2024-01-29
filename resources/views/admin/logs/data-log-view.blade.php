{{-- <pre><code class="language-json">{!! $data !!}</code></pre> --}}

{!! $data !!}

{{-- @foreach ($data as $key => $value)
            {{ $key }} =>
            @if (is_object($value))
                @foreach ($value as $valueKey => $vValue)
                    {{ $valueKey }} => {{ $vValue }}
                @endforeach
            @else
                {{ $key }} => {{ $value }}
            @endif
        @endforeach --}}
