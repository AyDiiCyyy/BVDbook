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
    public function up()
    {
        // Thêm ràng buộc check cho cột usage_limit
        DB::statement('ALTER TABLE vouchers ADD CONSTRAINT check_usage_limit_non_negative CHECK (usage_limit >= 0)');
    }

    public function down()
    {
        // Nếu rollback, xóa ràng buộc
        DB::statement('ALTER TABLE vouchers DROP CONSTRAINT check_usage_limit_non_negative');
    }
};
