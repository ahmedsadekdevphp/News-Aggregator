<section class="mb-4">
    <header>
        <h2 class="h5 text-dark font-weight-bold">
            {{ __('Update Password') }}
        </h2>
        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input
                type="password"
                id="update_password_current_password"
                name="current_password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input
                type="password"
                id="update_password_password"
                name="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input
                type="password"
                id="update_password_password_confirmation"
                name="password_confirmation"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small ms-3" id="statusMessage">{{ __('Saved.') }}</span>
                <script>
                    // Hide the success message after 2 seconds
                    setTimeout(() => {
                        const statusMessage = document.getElementById('statusMessage');
                        if (statusMessage) {
                            statusMessage.style.display = 'none';
                        }
                    }, 2000);
                </script>
            @endif
        </div>
    </form>
</section>
