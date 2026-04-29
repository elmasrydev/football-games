@props(['placeholder' => __('Your answer here...'), 'answerType' => 'player', 'submitLabel' => __('Check Answer')])

<div class="space-y-4">
    <div class="relative group">
        <label for="answer-input" class="absolute -top-2.5 start-4 px-2 bg-surface text-[9px] font-display font-black text-primary uppercase tracking-widest z-10 transition-colors group-focus-within:text-secondary">
            {{ __('Type your answer') }}
        </label>
        <input type="text" 
               id="answer-input" 
               placeholder="{{ $placeholder }}"
               data-answer-type="{{ $answerType }}"
               autocomplete="off"
               class="w-full bg-surface-variant/30 border border-outline-variant/30 rounded-2xl px-6 py-3 text-base font-display font-black text-on-surface placeholder:text-on-surface-variant/30 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all uppercase tracking-tight">
        
        <div id="autocomplete-list" class="absolute z-50 w-full mt-2 glass-card rounded-2xl shadow-2xl max-h-64 overflow-y-auto border-outline-variant/20 divide-y divide-outline-variant/10"></div>
    </div>

    <div class="flex flex-wrap gap-4">
        <button id="submit-btn" class="flex-1 min-w-[160px] bg-primary text-on-primary font-display font-black uppercase tracking-widest py-3 rounded-2xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
            {{ $submitLabel }}
        </button>
        <button id="clear-btn" class="px-6 glass-card text-on-surface-variant hover:text-primary font-display font-black uppercase tracking-widest text-[10px] rounded-2xl transition-all active:scale-95">
            {{ __('Clear') }}
        </button>
    </div>
</div>
