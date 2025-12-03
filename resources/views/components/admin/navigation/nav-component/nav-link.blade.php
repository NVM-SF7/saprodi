@props(['href', 'icon'])

<li>
    <a
    @isset($href)
        href='{{$href}}'
    @else
        href='/'
    @endisset  aria-expanded="false">
        <i class="
        @isset($icon)
            icon {{$icon}}
        @else
            icon
        @endisset
        ">
        </i><span class="nav-text">
            {{$slot}}
        </span>
    </a>
</li>
