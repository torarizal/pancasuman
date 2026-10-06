<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static void creating(\Closure $callback)
 * @method static void updating(\Closure $callback)
 * @method static \Illuminate\Database\Eloquent\Builder where(string $column, mixed $operator = null, mixed $value = null)
 */
trait HasSlug
{
    /**
     * Boot trait untuk secara otomatis meng-generate slug unik.
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $sourceField = property_exists($model, 'slugSourceField') ? $model->slugSourceField : 'name';
            
            $sourceValue = $model->getAttribute($sourceField);

            if (empty($model->getAttribute('slug')) && !empty($sourceValue)) {
                $model->setAttribute('slug', static::generateUniqueSlug((string) $sourceValue));
            }
        });

        static::updating(function (Model $model) {
            $sourceField = property_exists($model, 'slugSourceField') ? $model->slugSourceField : 'name';
            
            $sourceValue = $model->getAttribute($sourceField);

            if ($model->isDirty($sourceField) && !empty($sourceValue)) {
                $model->setAttribute('slug', static::generateUniqueSlug((string) $sourceValue, $model->getKey()));
            }
        });
    }

    /**
     * Helper untuk membuat slug unik di database.
     */
    public static function generateUniqueSlug(string $title, int|string|null $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}