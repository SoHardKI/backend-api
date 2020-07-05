<?php

namespace App\Console\Commands;

use App\Product;
use App\Property;
use Illuminate\Console\Command;

class CompoundProductProperty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:property';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compound product with property';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::all();
        foreach ($products as $product) {
            for ($i = 0; $i < rand(1, 30); ++$i) {
                $property = Property::find(rand(1, Property::all()->count()));
                $product->properties()->save($property);
            }
        }
    }
}
