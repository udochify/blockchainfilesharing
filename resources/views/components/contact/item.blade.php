@props(['name', 'address', 'checkbox'=>'', 'role'=>'', 'checked'=>''])

<div title="{{ $role.$address }}" {{ $attributes->merge(['class' => "relative flex flex-col border border-solid border-gray-300 mx-1"]) }}>
    <input class="contacts {{ $checkbox }} opacity-90 absolute top-0 right-0 w-4 h-4 p-0 m-[2px]" type="checkbox" {{ $checked }} name="share-with-me" value="{{ $address }}" />
    <div class="w-full h-auto"><img class="w-full" src="img/user-icon.png" /></div>
    <div class="w-full px-1 border-t border-solid border-gray-300"><p class="w-full text-center text-xs text-gray-500 overflow-hidden p-0 m-0">{{ $name }}</p></div>
</div>