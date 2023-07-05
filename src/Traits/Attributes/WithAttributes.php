<?php

declare(strict_types=1);

namespace Shopper\Core\Traits\Attributes;

use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\ProductAttribute;

trait WithAttributes
{
    public function attributeModelValue(string $type): string
    {
        if (in_array($type, ['text', 'number', 'richtext', 'select', 'datepicker', 'radio'])) {
            return 'single';
        } else {
            return 'multiple';
        }
    }

    public function getAttributes(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Attribute::query()
            ->whereNotIn('id', $this->productAttributes->pluck('attribute_id')->toArray())
            ->where('is_enabled', true)
            ->get();
    }

    public function getProductAttributes(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        return ProductAttribute::query()
            ->with('values')
            ->where('product_id', $this->product->id)
            ->get()
            ->map(function ($pa) {
                $pa['type'] = $pa->attribute->type;
                $pa['model'] = $this->attributeModelValue($pa->attribute->type);

                return $pa;
            });
    }
}
