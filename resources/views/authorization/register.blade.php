<x-guest-layout>
    <div class="flex flex--full">
        <div class="card card--full">
            <form class="form form--full" method="POST" action="{{ route('guest.register-post') }}">
                @csrf
                <h3 class="form__title">Signup</h3>

                <!-- Username -->
                <div class="form__group">
                    <label for="name" class="form__label">Username</label>
                    <input id="name" type="text" class="form__input" name="name" value="{{ old('name') }}" required autocomplete="username" autofocus>
                    @error('name')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- E-mail -->
                <div class="form__group">
                    <label for="email" class="form__label">E-mail</label>
                    <input id="email" type="email" class="form__input" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form__group">
                    <label for="password" class="form__label">Password</label>
                    <input id="password" type="password" class="form__input" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form__group">
                    <label for="password_confirmation" class="form__label">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form__input" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form__group">
                    <button type="submit" class="button button--primary button--form">
                        {{ __('Signup') }}
                    </button>
                </div>

                <div class="form__group form__group--links">
                    <hr class="form__hr">
                    <span class="form__or">or</span>
                    <hr class="form__hr">
                </div>

                <div class="form__group form__group--links">
                    <a href="{{ route('guest.login') }}" class="form__link">Login</a>
                </div>

                <h4 class="form__logo">RestApp</h4>
            </form>
        </div>
    </div>
</x-guest-layout>