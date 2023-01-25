<form id="contact-form" method="POST" action="{{ route('contact.add') }}" enctype="multipart/form-data">
    @csrf
    <div class="flex flex-col py-3">
        <div class="relative flex flex-row items-center">
            <div class="w-3/4">
                <x-file.input id="contact-input" type="text" name="address" class="form-control block m-0 p-0 pl-1 w-full" required autofocus />
            </div>
            <div class="flex flex-col items-end mt-0 w-fit ml-2">
                <x-file.button id="contact-button">
                    {{ __('Add Contact') }}
                </x-file.button>
            </div>
            <div id="loading-gif-contact" class="loading-gif w-11 ml-2 my-[-5px]">
                
            </div>
        </div>
    </div>
</form>