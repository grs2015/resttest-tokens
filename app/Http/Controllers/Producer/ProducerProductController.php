<?php

namespace App\Http\Controllers\Producer;

use App\Models\Product;
use App\Models\Producer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ProducerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Producer $producer)
    {
        $products = $producer->products()->without('producer')->get();

        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Producer $producer)
    {
        $request->validate([
            'title' => 'required|unique:products,title',
            'description' => 'required',
            'price' => 'required|numeric|between:1,100000',
            'image' => 'required|image'
        ]);

        $slug = $this->getSlug($request->title);

        $productData = $request->only(['title', 'description', 'price']);
        $productData['status'] = Product::UNAVAILABLE_PRODUCT;
        $productData['image'] = $request->image->store('', 'products');
        $productData['producer_id'] = $producer->id;
        $productData['slug'] = $slug;

        $product = Product::create($productData);

        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producer $producer, Product $product)
    {
        $request->validate([
            'price' => 'numeric|between:1,100000',
            'image' => 'image',
            'status' => Rule::in([Product::UNAVAILABLE_PRODUCT, Product::AVAILABLE_PRODUCT])
        ]);

        $slug = $product->slug;

        $this->checkProducer($producer, $product);

        $product->fill($request->only(['title', 'description', 'price']));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories->count() == 0) {
                return $this->errorResponse('An active product must have at least one category', Response::HTTP_CONFLICT);
            }
        }

        if ($request->hasFile('image')) {
            try {
                Storage::disk('products')->delete($product->image);
            } catch (\Exception $e) {
                throw $e;
            }

            if ($request->has('title')) {
                $slug = $this->getSlug($request->title);
            }

            $product['image'] = $request->image->store('', 'products');
            $product['slug'] = $slug;
        }

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producer $producer, Product $product)
    {
        $this->checkProducer($producer, $product);

        $product->delete();
        //TODO Реализовать логику очистки моделей SoftDelete по расписнанию вместе с ресурсами, в т.ч. изображениями

        return $this->showOne($product);
    }

    public function checkProducer(Producer $producer, Product $product) {
        if ($producer->id != $product->producer_id) {
            throw new HttpException(422, 'The specified producer is not the actual producer of the product');
        }
    }

    protected function getSlug($title) {
        return Str::slug(trim(strtolower($title)));
    }
}
