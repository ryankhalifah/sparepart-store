<div class="mb-4 shadow-sm card">
    <div class="text-white card-header bg-primary">
        <h4 class="mb-0"><i class="fas fa-key"></i> {{ __('Update Password') }}</h4>
    </div>
    <div class="card-body">
        <p class="mb-3 text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                <input type="password" id="current_password" name="current_password" class="form-control" autocomplete="current-password">
                @error('current_password')
                    <div class="mt-1 text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                @error('password')
                    <div class="mt-1 text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                @error('password_confirmation')
                    <div class="mt-1 text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="gap-2 d-flex align-items-center">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <span class="text-success ms-2">{{ __('Saved.') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>
