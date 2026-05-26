@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-lg">
        <div class="glass-card rounded-[2.5rem] p-8 sm:p-12 border-outline-variant/10 shadow-2xl relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-secondary/5 rounded-full blur-3xl -ml-24 -mb-24"></div>

            <div class="relative z-10 space-y-8">
                <div class="text-center space-y-2">
                    <h1 class="text-3xl font-display font-black uppercase tracking-tight text-on-background">
                        {{ __('Account Settings') }}
                    </h1>
                    <p class="text-on-surface-variant text-sm font-medium">
                        {{ __('Manage your profile details and preferences.') }}
                    </p>
                </div>

                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-500 text-xs font-display font-bold uppercase tracking-widest p-4 rounded-xl text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Profile Header (Avatar + Name) -->
                    <div class="flex flex-col items-center gap-4 pb-4">
                        <div class="w-24 h-24 rounded-3xl bg-primary/10 flex items-center justify-center text-primary font-display font-black text-4xl uppercase shadow-inner border border-primary/20">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <div class="text-center">
                            <span class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant/40">{{ __('Connected via Google') }}</span>
                            <p class="text-on-surface font-display font-black uppercase">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Display Name -->
                        <div class="space-y-1">
                            <label for="name" class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant px-1">
                                {{ __('Display Name') }}
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   class="w-full bg-surface-variant/30 border border-outline-variant/30 rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition-all @error('name') border-red-500 @enderror"
                                   placeholder="{{ __('Enter your name') }}">
                            @error('name')
                                <p class="text-[10px] text-red-500 font-display font-bold uppercase mt-1 px-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-primary text-on-primary font-display font-black uppercase tracking-widest py-4 rounded-xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>

                <div class="pt-8 border-t border-outline-variant/10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-center text-xs font-display font-black uppercase tracking-widest text-on-surface-variant/60 hover:text-red-500 transition-colors">
                            {{ __('Log Out of Account') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
