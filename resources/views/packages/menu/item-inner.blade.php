@if($menuitem->custom_view_name == null)
    <a href="{{ $menuitem->link }}">
        @if($menuitem->iconclass != null)
            <i class="{{ $menuitem->iconclass }}"></i>
        @endif
        <span>{{ $menuitem->label }}</span>
    </a>
@else
    @include($menuitem->custom_view_name)
@endif