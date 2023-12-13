


    <link rel="stylesheet" href="{{asset('static/app/css/app.min.css')}}">


	@yield('css')

    @if ($css = get_custom_css())
        <style>
        {!! $css !!}
        </style>
    @endif

    @if ($links = get_css_link())

    @foreach ($links as $link)

    <link rel="stylesheet" href="{{$link}}">


    @endforeach

    
    @if (($pwa = get_option('settings')->pwa) && $pwa->active)

      <link rel="stylesheet" href="{{asset("static/app/css/pwa.css")}}">
      
    @endif



    @endif

    {!! $html->getAndCleanCss() !!}
