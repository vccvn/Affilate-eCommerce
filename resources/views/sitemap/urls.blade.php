{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

@if(isset($list))
    @foreach($list as $item)
    @if ($u = $item['url'])
    <url>
        <loc>{{$u}}</loc>
        <changefreq>always</changefreq>
        <lastmod>{{str_replace(' ', 'T', $item['time'])}}+07:00</lastmod>
        <priority>1</priority>
    </url>
    @endif
    @endforeach
@endif
</urlset>