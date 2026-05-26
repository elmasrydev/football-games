@props(['challenge', 'game'])

<div class="sequence-shell">
    @php 
        $nodesData = $challenge->stimulus_data['nodes'] ?? $challenge->stimulus_data['clubs'] ?? [];
        $headerImage = $challenge->stimulus_data['header_image'] ?? $challenge->stimulus_data['player_image'] ?? null;
        
        // Resolve node details
        $resolvedNodes = collect($nodesData)->map(function($node) {
            if (!isset($node['name']) && isset($node['external_id'])) {
                $type = $node['type'] ?? 'club';
                $dbItem = \App\Models\GameItem::ofType($type)->where('external_id', $node['external_id'])->first();
                if ($dbItem) {
                    $node['name'] = app()->getLocale() === 'ar' ? $dbItem->name_ar : $dbItem->name_en;
                    $node['logo'] = $dbItem->getFirstMediaUrl('image');
                }
            }
            return $node;
        });
    @endphp

    <div class="sequence-stage-meta">
        <span class="stimulus-tag">{{ __('Challenge Mode') }}</span>
        <strong>{{ $game->localized_title }}</strong>
    </div>

    <div class="sequence-box">
        <div class="sequence-panel-glow"></div>
    
        @if($headerImage)
            <div class="header-avatar">
                <img src="{{ str_contains($headerImage, 'http') ? $headerImage : asset('storage/' . $headerImage) }}" alt="{{ __('Mystery') }}">
            </div>
        @endif
    
        <div class="nodes-timeline">
            @foreach($resolvedNodes as $node)
                <div class="timeline-item">
                    @if(isset($node['label']) || isset($node['year']))
                        <span class="timeline-year">{{ $node['label'] ?? $node['year'] }}</span>
                    @endif
                    <span class="timeline-dot"></span>
                    <div class="node-info-card">
                        @if(!empty($node['logo']))
                            <img src="{{ $node['logo'] }}" alt="{{ $node['name'] ?? __('Item') }}" class="node-logo">
                        @else
                            <div class="node-logo-placeholder">{{ mb_substr($node['name'] ?? '?', 0, 1) }}</div>
                        @endif
                        <span class="node-name">{{ $node['name'] ?? __('Unknown') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    
        <div class="stimulus-instruction">{{ $challenge->stimulus_data['instruction'] ?? __('Follow the chain!') }}</div>
    </div>
</div>

<style>
    .sequence-shell {
        display: grid;
        gap: 0.9rem;
        width: 100%;
    }

    .sequence-stage-meta {
        display: grid;
        gap: 0.35rem;
        padding-inline: 0.2rem;
    }

    .stimulus-tag {
        display: inline-flex;
        width: fit-content;
        padding: 0.42rem 0.75rem;
        border-radius: 999px;
        background: rgba(var(--surface-rgb), 0.75);
        border: 1px solid var(--border-soft);
        color: var(--text-soft);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .sequence-stage-meta strong {
        color: var(--text);
        font-family: var(--font-display);
        font-size: clamp(1.05rem, 2vw, 1.35rem);
        line-height: 1.1;
        letter-spacing: -0.03em;
    }

    .sequence-box {
        background:
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.12), transparent 28%),
            radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.1), transparent 24%),
            var(--surface);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft);
        border-radius: 28px;
        padding: clamp(1.5rem, 4vw, 3rem);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 350px;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .sequence-panel-glow {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent 40%);
        pointer-events: none;
    }

    .header-avatar img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid var(--accent); margin-bottom: 2.5rem; box-shadow: 0 18px 30px rgba(15,23,42,0.18); position: relative; z-index: 1; }
    
    .nodes-timeline { display: flex; gap: 3rem; flex-wrap: wrap; justify-content: center; align-items: start; position: relative; z-index: 1; width: 100%; }
    .timeline-item { display: flex; flex-direction: column; align-items: center; gap: 0.75rem; position: relative; }
    .timeline-year { font-weight: 800; font-size: 1.1rem; color: var(--text); }
    .timeline-dot { width: 16px; height: 16px; background: var(--accent); border-radius: 50%; box-shadow: 0 0 10px rgba(59, 130, 246, 0.25); }
    
    .node-info-card {
        background: rgba(var(--surface-muted-rgb), 0.9); border: 1px solid var(--border-soft); border-radius: 18px;
        padding: 0.75rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        min-width: 110px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s;
    }
    .node-info-card:hover { transform: translateY(-5px); }
    
    .node-logo { width: 48px; height: 48px; object-fit: contain; }
    .node-logo-placeholder { width: 48px; height: 48px; background: rgba(59, 130, 246, 0.12); border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: 800; color: var(--accent-strong); font-size: 1.5rem; }
    .node-name { font-size: 0.85rem; font-weight: 700; color: var(--text); text-align: center; }

    .timeline-item:not(:last-child)::after {
        content: ''; position: absolute; top: 35px; left: calc(50% + 8px); width: calc(100% + 1.5rem); height: 2px;
        background: var(--border-strong); z-index: 0;
    }

    .stimulus-instruction { margin-top: 3rem; color: var(--text-soft); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; position: relative; z-index: 1; }

    @media (max-width: 640px) {
        .sequence-box {
            padding: 1.25rem;
            min-height: 280px;
        }

        .nodes-timeline {
            gap: 1.6rem;
        }

        .timeline-item:not(:last-child)::after {
            width: calc(100% + 0.8rem);
        }
    }
</style>
