@foreach($shared as $file)
<x-shared.item :file="$file" class="hover:bg-green-200 bg-green-100 relative w-full" />
@endforeach