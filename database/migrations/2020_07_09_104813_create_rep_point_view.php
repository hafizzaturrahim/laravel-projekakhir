<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepPointView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW show_point AS
            select a.id, name, email, ifnull(sum(b.point),0) as 'point' from users a left join rep_points b on a.id = b.id group by a.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       DB::statement("DROP VIEW show_point");
   }
}
