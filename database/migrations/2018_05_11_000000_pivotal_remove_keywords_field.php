<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotalRemoveKeywordsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('blog_posts') && Schema::hasColumn('blog_posts', 'meta_keywords')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->dropColumn('meta_keywords');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('meta_keywords');
        });
    }
}
