{{-- <form method="POST" action="{{ route('otp.verify.post') }}">
    @csrf
    <div>
        <label for="otp">Enter OTP</label>
        <input type="text" name="otp" required autofocus>
    </div>

    <div>
        <button type="submit">Verify OTP</button>
    </div>
</form> --}}
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, please enter the OTP sent to your email address to verify your account.') }}
    </div>

    <form method="POST" action="{{ route('otp.verify.post') }}">
        @csrf
        <div class="mt-4">
            <label for="otp" class="block text-sm font-medium text-gray-700">{{ __('Enter OTP') }}</label>
            <input type="text" name="otp" required autofocus
                   class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Enter your OTP">
        </div>

        @error('otp')
            <div class="mt-2 text-sm text-red-600">
                {{ $message }}
            </div>
        @enderror

        <div class="mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="background-color:black">
                {{ __('Verify OTP') }}
            </button>
        </div>
    </form>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('otp.resend') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend OTP') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
