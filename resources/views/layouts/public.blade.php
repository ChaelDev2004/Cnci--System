<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', $siteSettings->brandName() . ' Church')</title>
  <link rel="icon" href="{{ $siteSettings->faviconUrl() }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @include('layouts.partials.public-styles')
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', system-ui, sans-serif;
      color: #222;
      background: #fff;
      line-height: 1.6;
    }
    img { max-width: 100%; display: block; }
    a { color: inherit; }
  </style>
  @stack('styles')
  @yield('head')
</head>
<body @auth class="is-auth" @endauth>
  @include('layouts.partials.public-nav')

  <main>
    @yield('content')
  </main>

  @include('layouts.partials.public-footer')
  @include('layouts.partials.public-scripts')
  @stack('scripts')
  @yield('scripts')
</body>
</html>
