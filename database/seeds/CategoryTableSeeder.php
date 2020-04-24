<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = 'Tabacaria';
        $category->save();
        $category->category_statistics()->create(['category_id' => $category->id]);

        #

        $category1 = new Category();
        $category1->name = 'Show';
        $category1->save();
        $category1->category_statistics()->create(['category_id' => $category1->id]);

        #

        $category2 = new Category();
        $category2->name = 'Balada';
        $category2->save();
        $category2->category_statistics()->create(['category_id' => $category2->id]);

        #

        $category3 = new Category();
        $category3->name = 'Bares';
        $category3->save();
        $category3->category_statistics()->create(['category_id' => $category3->id]);
    }
}
