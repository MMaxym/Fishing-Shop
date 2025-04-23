<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `trigger_actual_price`;');
        DB::unprepared('CREATE TRIGGER trigger_actual_price BEFORE INSERT ON categories
            FOR EACH ROW
            BEGIN
                DECLARE urlPath VARCHAR(255);
                IF NEW.parent_id IS NULL
                THEN
                    SET NEW.url_path = LOWER(NEW.slug);
                ELSE
                    SELECT url_path INTO urlPath FROM
                    categories WHERE categories.id = NEW.parent_id;
                    SET NEW.url_path = LOWER(concat(urlPath, "/", NEW.slug));
                END IF;
            END
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `trigger_actual_price`');
    }
};
