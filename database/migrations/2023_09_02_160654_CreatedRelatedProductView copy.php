<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW related_products_view AS
                SELECT
                    pr.id AS related_product_id,
                    u.name,
                    pr.product_id,
                    pr.related_id,
                    p.title,
                    SUBSTRING(p.description, 1, 50) AS description_short,
                    pp.url AS main_photo_url,
                    AVG(pf.rating) AS average_rating,
                    COUNT(pf.id) AS total_votes,
                    p.price
                FROM
                    product_related pr
                JOIN
                    products p ON pr.related_id = p.id
                JOIN
                	users u on p.user_id = u.id
                LEFT JOIN
                    product_photos pp ON pr.related_id = pp.product_id AND pp.main = 1
                LEFT JOIN
                    product_feedback pf ON pr.related_id = pf.product_id
                GROUP BY
                    pr.id, pr.product_id, pr.related_id, p.title, p.description, pp.url, u.name, p.price
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS related_products_view");
    }

};
