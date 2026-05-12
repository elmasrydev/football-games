<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Game extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected const ARABIC_DESCRIPTIONS = [
        'guess-silhouette' => 'تعرف على هوية اللاعب من خلال ظله فقط.',
        'anagram-arena' => 'قم بإعادة ترتيب الحروف المبعثرة للكشف عن اسم اللاعب.',
        'transfer-chain' => 'خمن اسم اللاعب من خلال تتبع مسيرة انتقالاته بين الأندية.',
        'stadium-spotter' => 'تعرف على اسم الملعب الشهير من خلال صورته.',
        'vowel-void' => 'املأ حروف العلة الناقصة لإكمال اسم اللاعب الصحيح.',
        'kit-detective' => 'تعرف على الفريق أو اللاعب من خلال تفاصيل طقم اللعب.',
        'black-and-white' => 'تعرف على أساطير اللعبة من خلال صورهم الكلاسيكية القديمة.',
        'highlight-moments' => 'تعرف على المباراة أو اللاعب من خلال احتفال تاريخي شهير.',
        'trophy-hunter' => 'تعرف على اللاعب أو الفريق من خلال سجل بطولاته وإنجازاته.',
        'terminology-trivia' => 'خمن الكلمة بناءً على تعريفها أو وصفها في مختلف المجالات.',
        'missing-link' => 'اعثر على الكلمة التي تربط بين هذه المصطلحات الكروية.',
        'career' => 'تتبع الأندية التي لعب لها النجم للتعرف على هويته.',
        'group-players' => 'تعرف على الرابط المشترك الذي يجمع بين مجموعة من اللاعبين.',
    ];

    protected $fillable = [
        'title',
        'name_ar',
        'slug',
        'description',
        'description_ar',
        'image',
        'game_type',
        'answer_type',
        'is_active',
        'how_to_play',
        'how_to_play_ar',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function scopeActiveWithChallenges($query, $language = null)
    {
        $query = $query->where('is_active', true);
        if ($language) {
            return $query->whereHas('challenges', function($q) use ($language) {
                $q->where('language', $language)->where('is_active', true);
            });
        }
        return $query->has('challenges');
    }

    public function getImageUrlAttribute(): ?string
    {
        $path = null;
        $media = $this->getFirstMediaUrl('cover');
        
        if ($media) {
            return $media;
        }

        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return null;
    }

    public function getLocalizedTitleAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->name_ar ?: $this->title)
            : $this->title;
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        if (app()->getLocale() !== 'ar') {
            return $this->description;
        }

        return static::ARABIC_DESCRIPTIONS[$this->slug] ?? $this->description;
    }
    public function getLocalizedHowToPlayAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->how_to_play_ar ?: $this->how_to_play)
            : $this->how_to_play;
    }
}
