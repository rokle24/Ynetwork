<x-login-layout type="Reset password">
    <form method="POST" action="/send" class="pt-14  ">
        @csrf
        <div class="w3-container w3-center" style="max-width:400px; margin:auto;">
            <div class="w3-padding-large">
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="email" name="email" required type="email" placeholder="Email"></x-form-input>
                <x-form-error class="w3-margin-bottom" name="email"></x-form-error>
            </div>
            <div class="w3-padding-large">
                <button class="w3-button w3-black w3-round-xxlarge w3-padding-large w3-block w3-margin-bottom" type="submit">Send</button>
            </div>
        </div>
    </form>
</x-login-layout>
