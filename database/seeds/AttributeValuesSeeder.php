<?php

use Illuminate\Database\Seeder;
use App\Models\AttributeValue;

class AttributeValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = ['small', 'medium', 'large'];
        $lengths = ['vertical', 'horizontal'];

        foreach ($sizes as $size)
        {
            AttributeValue::create([
                'attribute_id'      =>  1,
                'value'             =>  $size,
                'price'             =>  null,
            ]);
        }

        foreach ($lengths as $length)
        {
            AttributeValue::create([
                'attribute_id'      =>  2,
                'value'             =>  $length,
                'price'             =>  null,
            ]);
        }
    }
}
