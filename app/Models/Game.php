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
        'guess-silhouette' => 'هل يمكنك التعرف على اللاعب من ظله فقط؟',
        'anagram-arena' => 'رتب الحروف المبعثرة لاكتشاف اسم اللاعب المخفي.',
        'transfer-chain' => 'اتبع رحلة اللاعبين بين الأندية واكتشف الإجابة.',
        'stadium-spotter' => 'خمن اسم الملعب من لقطته الجوية.',
        'vowel-void' => 'أكمل حروف العلة الناقصة لكشف الاسم.',
        'kit-detective' => 'تعرف على الفريق من لقطة مقربة لقميصه.',
        'black-and-white' => 'تعرف على الأسطورة من صورة قديمة بالأبيض والأسود.',
        'highlight-moments' => 'خمن الحدث من صورة احتفال شهيرة.',
        'trophy-hunter' => 'تعرف على اللاعب أو الفريق من خزانة بطولاته.',
        'football-glossary' => 'اختبر معرفتك بمصطلحات كرة القدم.',
        'missing-link' => 'اعثر على الكلمة التي تربط بين هذه المصطلحات الكروية.',
        'career' => 'اتبع الأندية لتتعرف على اللاعب.',
        'group-players' => 'اكتشف الرابط المشترك بين مجموعة من اللاعبين.',
    ];

    protected $fillable = [
        'genre_id',
        'title',
        'name_ar',
        'slug',
        'description',
        'image',
        'game_type',
        'answer_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function scopeActiveWithChallenges($query)
    {
        return $query->where('is_active', true)->has('challenges');
    }

    public function getImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMediaUrl('cover');
        return $media ?: ($this->image ? asset('storage/' . $this->image) : null);
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
}
