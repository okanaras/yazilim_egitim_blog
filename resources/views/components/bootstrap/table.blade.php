@isset($isResponsive)
    <div class="table-responsive">
@endisset
    <table class="table {{ $class ?? '' }}">
        @isset($columns)
            <thead>
                <tr>
                    {!!     $columns    !!}
                </tr>
            </thead>
        @endisset
        
        <tbody>
            <tr>
                {!!     $rows       !!}
            </tr>
        </tbody>
    </table>
@isset($isResponsive)
    </div>
@endisset
