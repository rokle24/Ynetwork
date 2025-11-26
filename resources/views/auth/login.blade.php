<x-login-layout type="Log in to you profile">
    {{-- Form --}}
    <form method="POST" action="/login" class="pt-14  ">
        @csrf
        <div class="w3-container w3-center" style="max-width:400px; margin:auto;">
            <div class="w3-padding-large">
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="email" name="email"
                    required type="email" placeholder="Email"></x-form-input>

                <x-form-error name="email" class="w3-margin-bottom"></x-form-error>

                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="password" name="password"
                    required type="password" placeholder="Password"></x-form-input>

                <x-form-error name="password" class="w3-margin-bottom"></x-form-error>

                <button class="w3-button w3-black w3-round-xxlarge w3-padding-large w3-block w3-margin-bottom">
                    Login
                </button>
                <hr class="w3-border-black w3-margin" style="border-width:2px;">
                <a class="w3-button w3-black w3-round-xxlarge w3-padding-large w3-block w3-margin-bottom"
                    href="/reset-request">
                    Reset Password
                </a>

                <a class="w3-button w3-black w3-round-xxlarge w3-padding-large w3-block" href="/register">
                    Register
                </a>
            </div>
        </div>

    </form>
</x-login-layout>