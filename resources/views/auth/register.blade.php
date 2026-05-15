@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 glass-card p-8 sm:p-12 rounded-[2.5rem] border-outline-variant/10 shadow-2xl relative overflow-hidden">
        <!-- Background Glow -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-secondary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-primary/10 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-display font-black uppercase tracking-[0.2em] mb-6">
                    {{ __('Join the Arena') }}
                </div>
                <h2 class="text-4xl font-display font-black uppercase tracking-tight text-on-surface mb-2">
                    {{ __('Sign Up') }}
                </h2>
                <p class="text-on-surface-variant text-sm font-medium opacity-60">
                    {{ __('Unlock bookmarks, progress tracking & more') }}
                </p>
            </div>

            <div class="mt-10 space-y-6">
                <!-- Social Login -->
                <div>
                    <a href="{{ route('auth.google.redirect') }}" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-white dark:bg-zinc-800 border border-outline-variant/30 rounded-2xl font-display font-bold text-sm uppercase tracking-widest hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all shadow-lg hover:shadow-xl active:scale-[0.98] group">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="group-hover:text-secondary transition-colors">{{ __('Sign up with Google') }}</span>
                    </a>
                </div>

                <!-- Form placeholder removed for Google-only login -->

                <div class="text-center pt-4">
                    <p class="text-xs text-on-surface-variant font-medium">
                        {{ __("Already have an account?") }}
                        <a href="{{ route('login') }}" class="text-secondary font-bold hover:underline ml-1">{{ __('Sign In instead') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
