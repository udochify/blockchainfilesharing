<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blockchain') }}
            </h2>
            @if(auth()->user()->address)
            <p>&nbsp(your address: {{ auth()->user()->address }})</p>
            @endif
        </div>
    </x-slot>

    <div id="main-panel" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                @if(!auth()->user()->address)
                <x-forms.register />
                @else
                <x-forms.contact />
                <div id="contact-panel" class="flex flex-row mb-3">
                    @foreach($contacts as $contact)
                    <x-contact.item :name="$contact->name" :address="$contact->address" class="hover:bg-gray-200 w-16" />
                    @endforeach
                </div>
                <x-forms.upload />
                @endif
                <x-session-status class="text-green-600" :status="session('success')" />
                <div id="ajax-status">

                </div>
                <div id="file-panel" class="mt-2">
                    @for($i = 0; $i < count($files);  $i++)
                    <x-file.item :file="$files[$i]" :shares="$shares[$i]" class="hover:bg-gray-200 relative w-full" />
                    @endfor
                    <div id="shared-panel" class="relative w-full">
                        @foreach($shared as $file)
                        <x-shared.item :file="$file" class="hover:bg-green-200 bg-green-100 relative w-full" />
                        @endforeach
                    </div>
                </div>
                <a id="share-check" href="{{ route('share.check') }}" class="hidden"></a>
            </div>
        </div>
    </div>
</x-app-layout>
