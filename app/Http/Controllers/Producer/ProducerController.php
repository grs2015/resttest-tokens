<?php

namespace App\Http\Controllers\Producer;

use App\Filters\ProducerFilter;
use App\Models\Producer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ProducerCollection;
use App\Http\Resources\ProducerResource;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class ProducerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProducerFilter $filters)
    {
        $producers = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            fn() => Producer::filter($filters)->get()
        );

        return $this->showAll($producers, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:producers|string|max:30',
            'description' => 'required|string',
            'image_logo' => 'image|required'
        ]);

        $slug = $this->getSlug($request->title);

        $producerData = $request->only(['title', 'description']);
        $producerData['image_logo'] = $request->image_logo->store('', 'producers');
        $producerData['slug'] = $slug;

        $newProducer = Producer::create($producerData);

        return $this->showOne($newProducer, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Producer $producer)
    {
        return $this->showOne($producer, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producer $producer)
    {
        $producer->fill($request->only(['title', 'description']));

        $slug = $producer->slug;

        if ($request->hasFile('image_logo')) {
            try {
                Storage::disk('producers')->delete($producer->image_logo);
            } catch (\Exception $e) {
                throw $e;
            }

            if ($request->has('title')) {
                $slug = $this->getSlug($request->title);
            }

            $producer['image_logo'] = $request->image_logo->store('', 'producers');
            $producer['slug'] = $slug;
        }

        if ($producer->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $producer->save();

        return $this->showOne($producer, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producer $producer)
    {
        $producer->delete();
        //TODO Реализовать логику очистки моделей SoftDelete по расписнанию вместе с ресурсами, в т.ч. изображениями
        // Storage::disk('producers')->delete($producer->slug.'/'.$producer->image_logo);

        return $this->showOne($producer, Response::HTTP_OK);
    }

    protected function getSlug($title) {
        return Str::slug(trim(Str::remove(Producer::PRODUCER_SUFFIXES, strtolower($title))));
    }
}
