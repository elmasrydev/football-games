@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-8">
    <div class="max-w-md w-full text-center space-y-8 glass-card border-primary/20 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-12 -left-12 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-secondary/10 rounded-full blur-2xl"></div>

        <div class="space-y-6 relative z-10">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center mx-auto shadow-xl border border-primary/30 animate-pulse">
                <span class="text-4xl">✍️</span>
            </div>
            
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-[10px] font-display font-black uppercase tracking-[0.2em]">
                    {{ __('Coming Soon') }}
                </div>
                <h1 class="text-4xl font-display font-black uppercase tracking-tight text-on-surface">
                    {{ __('Huroof') }} <span class="text-primary">حروف</span>
                </h1>
                <p class="text-on-surface-variant text-sm leading-relaxed max-w-sm mx-auto">
                    {{ __('Huroof multiplayer word battle is currently under active development. You will soon be able to create custom rooms, choose genres, and go head-to-head in speed spelling matches!') }}
                </p>
            </div>

            <div class="pt-6 border-t border-outline-variant/10">
                <a href="{{ route('multiplayer.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-surface-variant/50 text-on-surface font-display font-bold text-xs uppercase tracking-widest hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    {{ __('Back to Multiplayer') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
