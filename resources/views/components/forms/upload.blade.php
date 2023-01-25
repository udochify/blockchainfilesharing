<form id="file-form" method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
    @csrf
    <div class="flex flex-col">
        <div class="relative flex flex-row items-center">
            <div class="w-3/4">
                <x-file.input id="file-input" type="file" name="file" class="form-control block m-0 p-0 w-full" accept=".txt,.pdf,.csv,.xlx,.xls,.xlsx,.doc,.docx,.html,.css,.js,.jpg,.jpeg,.png,.gif,.mp4,.avi,.3gp,.webm,.wav,.ogg,.mp3" required autofocus />
            </div>
            <div class="flex flex-col items-end mt-0 w-fit ml-2">
                <x-file.button id="file-button">
                    &nbsp{{ __('Upload File') }}&nbsp
                </x-file.button>
            </div>
            <div id="loading-gif-upload" class="loading-gif w-11 ml-2 my-[-5px]">
                
            </div>
        </div>
        <div class="flex flex-row items-center w-1/2 mt-2">
            <x-label for="key" :value="__('Private Key')" class="w-fit" />
            <x-file.input id="file-key" type="password" name="key" class="form-control block h-4 m-0 ml-2 p-0 px-1 grow" required autofocus />
        </div>
    </div>
</form>