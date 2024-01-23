<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class RelatedProducts extends Model
{
    use HasFactory;
    protected $appends = ['image'];
    protected $fillable = [
        'product_id',
        'related_product_id',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function relatedProduct()
    {
        return $this->belongsTo(Product::class, 'related_product_id');
    }
    

    public function getImageAttribute()
    {
        if (!empty($this->relatedProduct->image)) {
            $modifiedImages = [];
            $images = json_decode($this->relatedProduct->image,true);
            foreach ($images as $image) {
                $modifiedImages[] = config('app.url') . '/storage/product/' . $image;
            }
            $this->relatedProduct->image = $modifiedImages;
             return $modifiedImages;
            // return config('app.url') . '/storage/products/' . $this->relatedProduct->image;
        }
        return null;
       
    }

    

}