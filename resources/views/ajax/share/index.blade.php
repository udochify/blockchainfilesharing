@foreach($shares as $share)
<x-contact.item :role="'Shared to: '" :name="$share->user_name" :address="$share->user_address" class="hover:bg-gray-200 w-10" />
@endforeach