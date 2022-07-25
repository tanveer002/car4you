<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\State;
use App\Models\User;
use App\Models\VariantValues;
use Illuminate\Database\Seeder;

class RequiredDataSeeder extends Seeder
{
    protected $totalUser = 4;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedDefaultUserAccount();
        $this->seedDefaultProducts();
        $this->seedDefaultProductVariants();
        $this->seedDefaultVariantValues();
        $this->seedDefaultStates();
        $this->seedDefaultLocations();
    }

    /**
     * Creates the default users account.
     *
     * @return void
     */
    protected function seedDefaultUserAccount()
    {
        $users = [
            'John Wick' => 'john@gmail.com',
            'Gino Pietermaai' => 'gino@gmail.com',
            'Json Derulo' => 'json@gmail.com',
            'Donald Duck' => 'donald@gmail.com',
        ];

        foreach ($users as $name => $email) {
            User::factory()
                ->withName($name)
                ->withEmail($email)
                ->create();
        }
    }

    /**
     * Creates the default products.
     *
     * @return void
     */
    protected function seedDefaultProducts()
    {
        $users = [
            'Car' => 'So much cars for you!',
            'Mobile' => 'So much mobiles for you!',
        ];

        foreach ($users as $name => $description) {
            Product::factory()
                ->withName($name)
                ->withDescription($description)
                ->create();
        }
    }

    /**
     * Creates the default product variants.
     *
     * @return void
     */
    protected function seedDefaultProductVariants()
    {
        $variants = [
            'Name',
            'Model',
            'Color',
            'Price',
        ];

        foreach ($variants as $variant) {
            ProductVariant::create([
                'product_id' => 1,
                'name' => $variant
            ]);
        }
    }

    /**
     * Creates the default variant values.
     *
     * @return void
     */
    protected function seedDefaultVariantValues()
    {
        $getCars = file_get_contents(base_path('resources/data/php-mastercars.json'));
        $cars = json_decode($getCars, true);

        $variantNameValues = [];
        $variantModelValues = [];

        foreach ($cars as $index => $car) {
            $variantNameValues[] = [
                'product_variant_id' => 1, // Name variant
                'value' => $car['value'],
                'title' => $car['title'],
            ];

            foreach ($car['models'] as $model) {
                $variantModelValues[] = [
                    'product_variant_id' => 2, // Model variant
                    'value' => $model['value'],
                    'title' => $model['title'],
                    'parent_id' => $index + 1, // Associative with name
                ];
            }
        }

        VariantValues::insert($variantNameValues); // insert names
        VariantValues::insert($variantModelValues); // insert models
    }

    /**
     * Creates the default states.
     *
     * @return void
     */
    protected function seedDefaultStates()
    {
        $getStates = file_get_contents(base_path('resources/data/php-masterstates.json'));
        $states = json_decode($getStates, true);

        State::insert($states);
    }

    /**
     * Creates the default states.
     *
     * @return void
     */
    protected function seedDefaultLocations()
    {
        $users = User::all();
        foreach ($users as $index => $user) {
            $user->locations()
                ->create(['state_id' => $index+1]);

            $product = Product::find(1);
            $product->locations()
                ->create(['state_id' => $index+1]);
        }
    }

}
