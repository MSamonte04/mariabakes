<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name'=>'Classic Chocolate Chip','category'=>'cookies','description'=>'Golden edges, gooey center, loaded with chocolate chips.','price'=>65,'unit'=>'per pc','tag'=>'Bestseller','sort_order'=>1],
            ['name'=>"S'mores Cookie",'category'=>'cookies','description'=>'Graham cracker dough, marshmallow, and a Hershey square on top.','price'=>75,'unit'=>'per pc','tag'=>'Fan Favorite','sort_order'=>2],
            ['name'=>'Red Velvet Brownie','category'=>'brownies','description'=>'Rich red velvet base with a cream cheese swirl. Fudgy perfection.','price'=>80,'unit'=>'per pc','tag'=>'Special','sort_order'=>1],
            ['name'=>'Classic Fudge Brownie','category'=>'brownies','description'=>'Dense, fudgy, intensely chocolatey. The OG brownie.','price'=>70,'unit'=>'per pc','tag'=>'Classic','sort_order'=>2],
            ['name'=>'Cookie Cake – 6"','category'=>'cookie-cakes','description'=>'Giant cookie cake with rosette piping. Perfect for celebrations.','price'=>650,'unit'=>'whole','tag'=>'Custom','sort_order'=>1],
            ['name'=>'Cookie Cake – 8"','category'=>'cookie-cakes','description'=>'Our biggest cookie cake, customizable message on top.','price'=>850,'unit'=>'whole','tag'=>'Custom','sort_order'=>2],
            ['name'=>'Mixed Box (6 pcs)','category'=>'boxes','description'=>'6 assorted cookies/brownies beautifully packaged in a gift box with ribbon.','price'=>380,'unit'=>'per box','tag'=>'Gift Box','sort_order'=>1],
            ['name'=>'Mixed Box (12 pcs)','category'=>'boxes','description'=>'12 assorted treats — perfect for pasalubong or gifts!','price'=>720,'unit'=>'per box','tag'=>'Gift Box','sort_order'=>2],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['available' => true]));
        }
    }
}
