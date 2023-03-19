@if($message = session('message'))
    <x-alert type="success" dismissible>

        {{$message}}
    </x-alert>
@endif
