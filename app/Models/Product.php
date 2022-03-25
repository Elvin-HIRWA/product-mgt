<?php
declare(strict_types=1);
namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity'       
    ];
    protected $hidden = ['updated_at','created_at'];


    protected $table = "products";


     /**
     * @param int $id
     * @return mixed
     */
    public function getProduct($id){
        $product = $this->where("id",$id)->first();
        return $product;
    }
/**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function updateProduct($id, array $attributes){
        $product = $this->getProduct($id);
        if($product == null){
            throw new ModelNotFoundException("Cant find this product");
        }

        $product->name = $attributes["name"];
        $product->description = $attributes["description"];
        $product->price = $attributes["price"];
        $product->quantity = $attributes["quantity"];
        $product->save();
        return $product;
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => intval($value),
        );
    }

    protected function quantity(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => intval($value),
        );
    }
    /**
     * @param int $id
     * @return mixed
     */
    public function deleteProduct($id){
        $product = $this->getProduct($id);
        if($product == null){
            throw new ModelNotFoundException("This Product not found");
        }
        return $product->delete();
}
}