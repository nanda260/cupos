@php
    $primaryColor    = optional($shopProfile ?? null)->primary_color ?? '#EF9F2E';
    $sidebarColor    = optional($shopProfile ?? null)->sidebar_color ?? '#1C1710';
    $bodyColor       = optional($shopProfile ?? null)->body_color ?? '#DAD4C6';
    $sidebarTextMode = optional($shopProfile ?? null)->sidebar_text_mode ?? 'light';
    [$pr, $pg, $pb] = sscanf($primaryColor, '#%02x%02x%02x');

    $sidebarTextRgb = $sidebarTextMode === 'dark' ? '20, 22, 28' : '255, 255, 255';
@endphp
<style>
    :root {
        --cupos-primary: {{ $primaryColor }};
        --cupos-primary-rgb: {{ $pr }}, {{ $pg }}, {{ $pb }};
        --cupos-sidebar-start: {{ $sidebarColor }};
        --cupos-sidebar-text-rgb: {{ $sidebarTextRgb }};
        --cupos-body-bg: {{ $bodyColor }};
    }
</style>