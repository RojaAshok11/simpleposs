@if ($type == 1)
    <script type="module">
        $("{{ $nameone }}").css({
            "background-color": "{{ App::make('themesetting') ? App::make('themesetting')->collapse_active_color : 'red' }}",
        });
    </script>
@else
    <script type="module">
        $("{{ $collapsename }}").addClass('show');
        $("{{ $nameone }}").css({
            "background-color": "{{ App::make('themesetting') ? App::make('themesetting')->collapse_active_color : 'red' }}",
            "margin-top": "2px"
        });
        $("{{ $nametwo }}").css({
            "background-color": "{{ App::make('themesetting') ? App::make('themesetting')->collapse_activesub_color : 'red' }}",
        });
    </script>
@endif
