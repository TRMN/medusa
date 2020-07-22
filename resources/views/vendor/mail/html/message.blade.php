@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <p>Copyright &copy; 2008 &ndash; {!! date('Y') !!} The Royal Manticoran Navy: The Official Honor Harrington
                Fan Association, Inc. Some Rights Reserved. Honor Harrington and all related materials are &copy; David
                Weber.</p>
            <span class="text-center"><img src="https://medusa.trmn.org/images/project-medusa.svg" width="150px"
                                           height="150px" data-src="https://medusa.trmn.org/images/project-medusa.svg"></span>
            <p>{!! Config::get('app.version') !!}</p>
        @endcomponent
    @endslot
@endcomponent
