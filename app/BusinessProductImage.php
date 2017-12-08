<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\BusinessP0roduct;
use Validator;
use Image;

class BusinessProductImage extends Model
{
	protected $mediaTempPath;
    protected $productImagePath;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mediaTempPath = config('image.media_temp_path');
        $this->productImagePath = config('image.product_image_path');
    }

    protected $fillable = ['user_id', 'business_id', 'business_product_id', 'image', 'featured_image'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'business_product_id' => "", 'image' => "", 'featured_image' => ""];

    public static $validater = array(
        'image' => 'required|image|mimes:jpg,png,jpeg',
    );

    public function images()
    {
        return explode('|', $this->image);
    }

    public function saveProductImages($input)
    {
        $fileType = null;
        $pproduct = null;

        $product = $this->saveImage($input);

        return true;
    }

    public function saveImage($input)
    { 
        $fileArray = json_decode($input['fileArray']);

        foreach($fileArray as $key => $file) {
            // get media name without extension
            $uniqueId = current(explode('.', $file));

            if ($this->image == null)
                $this->image = $uniqueId.'.png';
            else
                $this->image = $this->image . '|' . $uniqueId.'.png';

            rename($this->mediaTempPath.'/'.$key.'/'.$file, $this->productImagePath.'/'.$uniqueId.'.png');

            $img = Image::make($this->productImagePath.'/'.$uniqueId.'.png');

            $img->resize(intval(config('image.large_thumbnail_width')), null, function($constraint) {
                 $constraint->aspectRatio();
            });

            $img->save($this->productImagePath.'thumbnails/large/'.$uniqueId.'.png');

            $img->resize(intval(config('image.medium_thumbnail_width')), null, function($constraint) {
                 $constraint->aspectRatio();
            });

            $img->save($this->productImagePath.'thumbnails/medium/'.$uniqueId.'.png');

            $img->resize(intval(config('image.small_thumbnail_width')), null, function($constraint) {
                 $constraint->aspectRatio();
            });

            $img->save($this->productImagePath.'thumbnails/small/'.$uniqueId.'.png');

            $this->save();
        }
    }  
}
