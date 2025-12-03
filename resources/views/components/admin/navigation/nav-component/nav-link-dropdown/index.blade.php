<li>
    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
        <i class="icon icon-app-store"></i>
        <span class="nav-text">
            @isset($title)
                {{$title}}
            @endisset
                Title
        </span>
    </a>
    <ul aria-expanded="false">
        {{$slot}}
    </ul>
</li>
