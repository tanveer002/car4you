<?php

namespace App\Console\Commands;

use App\Models\State;
use App\Models\User;
use App\Models\VariantValues;
use Illuminate\Console\Command;

class DeliverProductToCustomerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:deliver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deliver Product To Customers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // TODO Collect users info: Customer, receive the product
        $user_id = $this->ask('What is the customer/user id to deliver the product? (1-4)');
        $user = User::find($user_id);
        if(!$user) return $this->error('User does not exist, or do you run all the migrations and seeders?');

        // TODO Collect products info: Product as model to be delivered
        $productIds = VariantValues::whereNull('parent_id')->pluck('id')->toArray();
        $this->info('You can select product id from these: '.(implode(',', $productIds)));

        $product_id = $this->ask('What is the product/car id for deliver to user?');
        $variant = VariantValues::find($product_id);

        if(!$variant || !$variant->whereNotNull('parent_id')->count())
            return $this->error('You can select product id from these: '.(implode(',', $productIds)));

        // TODO Collect products model info: Product model that your product has?
        $productModelIds = $variant->whereParentId($product_id)->pluck('id')->toArray();
        $this->info('You can select model id from these: '.(implode(',', $productModelIds)));

        $product_model_id = $this->ask('What is the product model id for deliver to user that your product has?');
        if(!VariantValues::whereId($product_model_id)->whereParentId($product_id)->count())
            return $this->error('You can select model id from these: '.(implode(',', $productModelIds)));

        // TODO Collect locations info: Customer delivery address
        $state_id = $this->ask('What is the Customer delivery address: the state id? (1-56)');
        $state = State::find($state_id);
        if(!$state) return $this->error('State does not exist, or do you run all the migrations and seeders?');;

        // TODO Collect locations data: backend
        $location = $user->locations()->create(['state_id' => $state_id]);

        $variant_model = VariantValues::find($product_model_id);
        $user->deliveries()->attach($variant_model->id,[
            'product_name' => $variant->value,
            'product_model' => $variant_model->product()->first()?->value,
            'location_id' => $location->id
        ]);

        $user_delivery = $user->deliveries();
        $user_delivery = $user_delivery->where('variant_value_id', $product_model_id);// : $user_delivery->wherePivot('variant_value_id', $product_id);
        $user_delivery = $user_delivery->first();

        $data = [
            'User Full Name' => $user->name,
            'Product Value' => $user_delivery->value,
            'Product Title' => $user_delivery->title,
            'Product Model Name' => $user_delivery->pivot->product_name,
            'Product Model Value' => $user_delivery->pivot->product_model,
            'Customer Location' => $location->state->name.' '.$location->state->capital
        ];

        dd($data);
    }
}
