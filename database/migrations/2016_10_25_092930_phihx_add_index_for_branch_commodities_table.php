<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxAddIndexForBranchCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_commodities', function (Blueprint $table) {
            $table->index(['branch_id', 'commodity_id', 'on_hand', 'company_id'],'branch_commodities_sale_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_commodities', function (Blueprint $table) {
            $table->dropIndex('branch_commodities_sale_index');
        });
    }
}
