<div class="col-10 d-none d-sm-block ml-0">
    <div id="crumbs" class="d-flex justify-content-end">
        <ul>
            @if(Navigation::crumbs())
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Home
                    </a>
                </li>
                @foreach (Navigation::crumbs() as $crumb)
                    <li>
                        <a href="{{ $crumb->link && !$loop->last ? $crumb->link : 'javascript:void(0)' }}" {{ $loop->last ? 'class=bg-danger' : '' }}>
                            <i class="{{ $crumb->icon }}" aria-hidden="true"></i>
                            {{ $crumb->value }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
