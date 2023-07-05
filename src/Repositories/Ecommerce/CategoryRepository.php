<?php

declare(strict_types=1);

namespace Shopper\Core\Repositories\Ecommerce;

use Shopper\Core\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model(): string
    {
        return config('shopper.models.category');
    }
}
