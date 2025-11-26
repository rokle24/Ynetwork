<x-login-layout type="Password Reset">
    <form method="POST" action="/reset" class="pt-14">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="flex flex-col items-center gap-5">
            <div class="flex flex-col gap-5">
                <x-form-input id="password" name="password" required type="password" placeholder="Password"></x-form-input>
                <x-form-input id="password_confirmation" name="password_confirmation" required type="password" placeholder="Confirm password"></x-form-input>
                <x-form-error name="password"></x-form-error>
            </div>
            <button class="bg-black text-white rounded-full py-2 px-4" type="submit">Send</button>
        </div>
    </form>
</x-login-layout>
