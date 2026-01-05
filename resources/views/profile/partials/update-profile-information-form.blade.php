<div class="mb-4 shadow-sm card">
    <div class="text-white card-header bg-primary">
        <h4 class="mb-0"><i class="fas fa-user"></i> {{ __('Profile Information') }}</h4>
    </div>
    <div class="card-body">
        <p class="mb-3 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>

        {{-- Form untuk re-send verification email --}}
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        {{-- Form update profile --}}
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="mt-1 text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="mt-1 text-danger">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="mb-1 text-muted">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="p-0 m-0 align-baseline btn btn-link">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 text-success">{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="gap-2 d-flex align-items-center">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success">{{ __('Saved.') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>
