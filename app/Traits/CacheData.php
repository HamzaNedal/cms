<?php
namespace App\Traits;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

trait CacheData {

   function recent_categories(){
        if(!Cache::has('recent_categories')){
            $recent_categories = Category::active()->descById()->get();
            Cache::remember('recent_categories', 3600, function ()use($recent_categories) {
                return $recent_categories;
            });
        }
        return  Cache::get('recent_categories');
   }

}