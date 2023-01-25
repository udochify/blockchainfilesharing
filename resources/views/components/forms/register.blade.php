<form id="blockchain-reg" action="{{ route('blockchain.register') }}" method="POST">
    @csrf
    <x-input-label for="email" :value="__('Email')" />
    <div class="flex flex-row left-0 align-middle">
        <div class="w-1/2 my-auto">
            <x-text-input class="block mt-1 w-full" type="email" name="email" :value="auth()->user()->email" required autofocus />
            <x-text-input class="hidden" type="text" name="name" :value="auth()->user()->name" />
        </div>
        <div class="ml-3 my-auto">
            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </div>
    <x-session-status class="text-red-600" :status="session('error')" />
</form>
<x-session-status class="text-gray-600" :status="__('Register on the blockchain. Check email for your private key after Registration.')" />