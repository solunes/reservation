<?php

namespace Solunes\Reservation\App\Listeners;

class AccommodationSaved
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if(!$product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','accommodation')->where('product_id', $event->id)->first()){
            $product_bridge = new \Solunes\Business\App\ProductBridge;
            $product_bridge->product_type = 'accommodation';
            $product_bridge->product_id = $event->id;
        }
        if($event->currency_id){
            $product_bridge->currency_id = $event->currency_id;
        } else {
            $product_bridge->currency_id = 1;
        }
        $product_bridge->price = $event->price;
        $product_bridge->name = $event->name;
        $image = \Asset::get_image_path('accommodation-image','normal',$event->image);
        $product_bridge->image = \Asset::upload_image(asset($image),'product-bridge-image');
        $product_bridge->content = $event->content;
        $product_bridge->active = $event->active;
        if(config('payments.sfv_version')>1||config('payments.discounts')){
            $product_bridge->discount_price = $event->discount_price;
        }
        if(config('payments.sfv_version')>1){
            $product_bridge->economic_sin_activity = $event->economic_sin_activity;
            $product_bridge->product_sin_code = $event->product_sin_code;
            $product_bridge->product_internal_code = $event->product_internal_code;
            $product_bridge->product_serial_number = $event->product_serial_number;
        }
        $product_bridge->stockable = 0;
        $product_bridge->save();
        return $event;
    }
}

