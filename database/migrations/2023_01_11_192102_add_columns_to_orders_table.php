<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon_discount')->after('discount')->default(0);
            $table->string('total')->after('total_amount')->default(0);
            $table->string('vat')->after('instruction')->default(0);
            $table->string('vat_type')->after('vat')->nullable();
            $table->string('delivery_cost')->after('vat_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_discount');
            $table->dropColumn('total');
            $table->dropColumn('vat');
            $table->dropColumn('vat_type');
            $table->dropColumn('delivery_cost');
        });
    }
}
