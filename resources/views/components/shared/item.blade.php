@props(['file'])
@php
    $creation_date = new DateTime($file->created_at);
    $creation_time = $creation_date->format('D, M j, Y \a\t g:i:s A');
    $owner_name = App\Models\User::firstWhere('address', $file->owner)->name;

    $styles = array('rar'=>['0 0','archive'],'pptx'=>['-55px 0','document'],'xlsx'=>['-111px 0','document'],'docx'=>['-167px 0','document'],
                    'dmg'=>['0 -66px','archive'],'apk'=>['-55px -66px','archive'],'zip'=>['-111px -66px','archive'],'png'=>['-167px -66px','picture'],
                    'psd'=>['0 -133px','archive'],'log'=>['-55px -133px','document'],'txt'=>['-55px -133px','document'],'csv'=>['-55px -133px','document'],'js'=>['-55px -133px','document'],'htm'=>['-55px -133px','document'],
                    'mp3'=>['-111px -133px','audio'],'wav'=>['-111px -133px','audio'],'ogg'=>['-111px -133px','audio'],'mp4'=>['-167px -133px','video'],
                    'ppt'=>['0 -200px','document'],'jpg'=>['-55px -200px','picture'],'xls'=>['-111px -200px','document'],'ai'=>['-167px -200px','archive'],
                    'css'=>['0 -267px','document'],'html'=>['-55px -267px','document'],'pdf'=>['-111px -267px','document'],'doc'=>['-167px -267px','document'],
                    'iso'=>['0 -66px','archive'],'3gp'=>['-167px -133px','video'],'avi'=>['-167px -133px','video'],'webm'=>['-167px -133px','video'],'jpeg'=>['-55px -200px','picture'],'gif'=>['-55px -200px','picture']);
@endphp
<div id="ajax-file{{$file->file_id}}" {{ $attributes->merge(['class'=>'flex flex-row items-end p-1 border-b border-solid border-b-gray-200']) }}>
    <a class="iframe-link {{ $styles[substr(strrchr($file->file_name,'.'),1)][1] }} leading-[0] m-0" href="#">
        <div class="flex-shrink-0 h-11 w-9" style="display: inline-block; background-image: url(img/file-icons.png); background-repeat: no-repeat; background-attachment: scroll; background-position: {{ $styles[substr(strrchr($file->file_name,'.'),1)][0] ?? $styles['txt'] }}">
        </div>
    </a>
    <div class="flex flex-col items-start ml-2">
        <div class="flex flex-row">
            <div id="download{{$file->file_id}}" title="download file" class="inline-block px-2 mr-1 text-xs leading-[1.125rem] cursor-pointer hover:bg-blue-500 font-semibold rounded-full bg-blue-400 text-white ajax-btn">
                download
            </div>
            <div id="reverse_unshare{{$file->id}}" title="unshare file" class="reverse_unshare{{$file->id}} inline-block px-2 mr-1 text-xs leading-[1.125rem] cursor-pointer hover:bg-green-500 font-semibold rounded-full bg-green-400 text-white ajax-btn">
                unshare
            </div>
            <div class="inline-block pr-2 text-sm font-medium text-gray-900">
                {{ $file->file_size }}
            </div>
        </div>
        <a class="iframe-link flex flex-row items-baseline {{ $styles[substr(strrchr($file->file_name,'.'),1)][1] }} leading-[0] m-0" href="{{ asset('storage/'.$file->file_path) }}">
            <div title="{{ $file->file_name }}"  class="w-fit w-max-[300px] whitespace-nowrap overflow-hidden text-sm -mb-[2px] mt-[2px] text-gray-500">
                {{ $file->file_name }}
            </div><p>...</p>
        </a>
        <form action="{{ route('files.download', $file->file_id) }}" method="POST" class="download{{$file->file_id}} hidden">@csrf</form>
        <form action="{{ route('files.unshare', $file->file_id) }}" class="unshare{{$file->file_id}} hidden">@csrf</form>
        <form action="{{ route('files.unshare_reverse', $file->file_id) }}" class="reverse_unshare{{$file->file_id}} hidden">@csrf</form>
    </div>
    <div class="share-panel flex flex-row border-l border-l-gray-300 border-solid h-full w-fit pl-2">
        <x-contact.item :role="'From: '" :name="App\Models\User::firstWhere('address', $file->owner)->name" :address="$file->owner" :checkbox="'hidden'" :checked="'checked'" class="hover:bg-gray-200 w-10" />
    </div>
    <div class="loading-gif w-11 ml-2 my-[-5px]">
                
    </div>
</div>