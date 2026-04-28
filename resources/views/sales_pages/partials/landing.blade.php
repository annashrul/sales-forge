@php
    $template = $page->template ?? 'modern';
@endphp

@switch($template)
    @case('classic')
        @include('sales_pages.partials.landing-classic', ['page' => $page])
        @break
    @case('bold')
        @include('sales_pages.partials.landing-bold', ['page' => $page])
        @break
    @default
        @include('sales_pages.partials.landing-modern', ['page' => $page])
@endswitch
