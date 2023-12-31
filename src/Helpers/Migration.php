<?php

declare(strict_types=1);

namespace Shopper\Core\Helpers;

use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Shopper\Core\Enum\Dimension\Length;
use Shopper\Core\Enum\Dimension\Volume;
use Shopper\Core\Enum\Dimension\Weight;

abstract class Migration extends BaseMigration
{
    protected string $prefix = '';

    public function __construct()
    {
        $this->prefix = config('shopper.core.table_prefix');
    }

    public function getTableName(string $table): string
    {
        return $this->prefix . $table;
    }

    public function addCommonFields(Blueprint $table, bool $hasSoftDelete = false): void
    {
        $table->id();
        $table->timestamps();

        if ($hasSoftDelete) {
            $table->softDeletes();
        }
    }

    public function addSeoFields(Blueprint $table): void
    {
        $table->string('seo_title', 60)->nullable();
        $table->string('seo_description', 160)->nullable();
    }

    public function addShippingFields(Blueprint $table): void
    {
        $table->string('weight_unit')->default(Weight::KG->value);
        $table->decimal('weight_value', 10, 5)->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('height_unit')->default(Length::CM->value);
        $table->decimal('height_value', 10, 5)->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('width_unit')->default(Length::CM->value);
        $table->decimal('width_value', 10, 5)->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('depth_unit')->default(Length::CM->value);
        $table->decimal('depth_value', 10, 5)->nullable()
            ->default(0.00)
            ->unsigned();
        $table->string('volume_unit')->default(Volume::L->value);
        $table->decimal('volume_value', 10, 5)->nullable()
            ->default(0.00)
            ->unsigned();
    }

    public function addForeignKey(Blueprint $table, string $columnName, string $tableName, bool $nullable = true): void
    {
        if ($nullable) {
            $table->unsignedBigInteger($columnName)->index()->nullable();
            $table->foreign($columnName)->references('id')->on($tableName)->onDelete('set null');
        } else {
            $table->unsignedBigInteger($columnName)->index();
            $table->foreign($columnName)->references('id')->on($tableName)->onDelete('CASCADE');
        }
    }

    public function removeLink(Blueprint $table, string $columnName): void
    {
        $table->dropForeign([$columnName]);
        $table->dropColumn([$columnName]);
    }
}
