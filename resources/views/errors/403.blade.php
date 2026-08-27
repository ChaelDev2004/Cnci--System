<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access denied — {{ $siteSettings->brandName() ?? 'CNCI' }}</title>
  <link rel="icon" href="{{ isset($siteSettings) ? $siteSettings->faviconUrl() : '' }}">
  @include('layouts.partials.cnci-ui')
</head>
<body>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      customClass: { popup: 'cnci-swal', confirmButton: 'cnci-confirm' },
      icon: 'error',
      title: 'Access denied',
      text: @json($exception->getMessage() ?: 'You do not have permission to view this page.'),
      confirmButtonText: 'Go back',
      allowOutsideClick: false,
    }).then(function () {
      if (window.history.length > 1) {
        window.history.back();
      } else {
        window.location.href = @json(url('/'));
      }
    });
  });
</script>
</body>
</html>
