<section class="main-stars-header pt-3">
    <div class="container main-stars-header-content">
        <h1>{{$title}}</h1>
        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb" class="pt-2">
            <ol class="breadcrumb d-flex align-items-center gap-2">
                @foreach($breadcrumbs as $breadcrumb => $url)
                    @if ($loop->last)
                        <li class="breadcrumb-item active fw-bold">{{$breadcrumb}}</li>
                    @else
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{$url}}">
                                {{$breadcrumb}}
                            </a>
                        </li>
                        <p class="text-white mb-0">/</p>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</section>