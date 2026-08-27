@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
$brandName = isset($siteSettings) ? $siteSettings->brandName() : 'CNCI Church';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column gap-2">
            <div class="text-body">
                &copy; {{ date('Y') }} {{ $brandName }}. All rights reserved.
            </div>
            <div class="d-none d-md-inline-block">
                <a href="{{ url('/') }}" class="footer-link me-4" target="_blank" rel="noopener">View Website</a>
                <a href="{{ route('admin.dashboard') }}" class="footer-link me-4">Dashboard</a>
                <a href="{{ url('/#contact') }}" class="footer-link" target="_blank" rel="noopener">Contact</a>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
