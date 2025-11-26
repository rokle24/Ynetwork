<x-login-layout type="Create new profile">
    {{-- Form --}}
    <form method="POST" action="/register" class="pt-14  ">
        @csrf
        <div class="w3-container w3-center" style="max-width:400px; margin:auto;">
            <div class="w3-padding-large">
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="first_name" name="first_name" type="text" required
                    placeholder="First name"></x-form-input>
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="last_name" name="last_name" type="text" required
                    placeholder="Last name"></x-form-input>
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="email" name="email" required type="email" placeholder="Email"></x-form-input>
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="email_confirmation" name="email_confirmation" required type="email"
                    placeholder="Confirm email"></x-form-input>
                <x-form-error class="w3-margin-bottom" name="email"></x-form-error>
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="password" name="password" required type="password"
                    placeholder="Password"></x-form-input>
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="password_confirmation" name="password_confirmation" required type="password"
                    placeholder="Confirm password"></x-form-input>
                <x-form-error class="w3-margin-bottom" name="password"></x-form-error>
                <x-form-input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" id="birthdate" name="birthdate" type="date" x-data x-on:input="
        const today = new Date();
        const eighteenYearsAgo = new Date(today.setFullYear(today.getFullYear() - 18));
        const selectedDate = new Date($el.value);
        $el.setCustomValidity(selectedDate > eighteenYearsAgo ? 'You must be at least 18 years old.' : '');
    " required></x-form-input>
            </div>
            <div class="w3-padding-large">
                <button class="w3-button w3-black w3-round-xxlarge w3-padding-large w3-block w3-margin-bottom" type="submit">Register</button>
            </div>
        </div>
    </form>


</x-login-layout>