@foreach($languages as $locale => $language)
    @break($loop->index > 0)
    <a href="{{route($route, array_merge(request()->route()?->parameters() ?? [], ['locale' => $locale], request()->query()))}}" class="text-decoration-none text-black">
        <span> {{$language}} </span>
        <picture>
            <img src="{{asset('/assets/icons/globe.svg')}}" alt="" />
        </picture>
    </a>
@endforeach