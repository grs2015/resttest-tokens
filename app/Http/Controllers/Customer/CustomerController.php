<?php

namespace App\Http\Controllers\Customer;

use App\Models\Branch;
use App\Models\Region;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Filters\CustomerFilter;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CustomerResource;
use Symfony\Component\HttpFoundation\Response;


class CustomerController extends ApiController
{
    // TODO Позднее реализовать вывод всех Customers, но без компании-владельца ресурса
    public function index(CustomerFilter $filters, Request $request)
    {
        $customers = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime($request),
            fn() => Customer::select('customers.*', 'region', 'branch')
                            ->join('regions', 'customers.region_id', 'regions.id')
                            ->join('branches', 'customers.branch_id', 'branches.id')
                            ->filter($filters)->get()
        );

        return $this->showAll($customers, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return $this->showOne($customer, Response::HTTP_OK);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'region_id' => 'integer',
            'branch_id' => 'integer',
            // 'title' => 'unique:customers',
            'title' => [Rule::unique('customers')->ignore($customer)],
            'image' => 'array',
            'email' => 'email',
            'deleteImage' => 'string'
        ]);

        $detail = $customer->detail;

        if ($request->has('deletedImage')) {
            $deletedImage = $request->deletedImage;
            try {
                Storage::disk('public')->delete($deletedImage);
            } catch(\Exception $e) {
                throw $e;
            }
            if (isset($detail['image'])) {
                $imagesAttached = collect(explode(",", $detail['image']));
                $fileNames = $imagesAttached->filter(function($value, $key) use ($deletedImage) {
                    return $value != $deletedImage;
                })->values();
                $fileNamesDB = $fileNames->implode(',');
                $detail['image'] = $fileNamesDB;
            }
            $detail->save();
            return response()->json(['data' => $fileNames]);
        }

        $slug = $customer->slug;

        if ($request->has('region_id')) {
            $id = $request->region_id;
            $newRegion = Region::findOrFail($id);
            $customer->region_id = $newRegion->id;
        }

        if ($request->has('branch_id')) {
            $id = $request->branch_id;
            $newBranch = Branch::findOrFail($id);
            $customer->branch_id = $newBranch->id;
        }

        // try {
        //     if ($request->hasFile('images')) {
        //         $file = $request->allFiles('images');
        //         $fileNames = collect([]);
        //         collect($file['images'])->each(function($item) use ($fileNames) {
        //             $fileNames->push($item->store('', 'customers'));
        //         });
        //         $fileNamesDB = $fileNames->implode(',');
        //         // return response()->json(['message' => $fileNamesDB], 200);
        //     }
        // } catch(\Exception $e) {
        //     return response()->json(['message' => $e->getMessage()]);
        // }

        $customer->fill($request->only(['title']));

        $detail->fill($request->only(['description', 'phone', 'email', 'website']));
        if ($request->hasFile('images')) {
            try {
                $namesArr = explode(",", $detail->image);
                Storage::disk('public')->delete($namesArr);

            } catch (\Exception $e) {
                throw $e;
            }

            if ($request->has('title')) {
                $slug = $this->getSlug($request->title);
            }

            $files = $request->allFiles('images');
            $fileNames = collect([]);
            collect($files['images'])->each(function($item) use ($fileNames) {
                $fileNames->push($item->store('img/customers', 'public'));
            });

            $fileNamesDB = $fileNames->implode(',');

            $detail['image'] = $fileNamesDB;
            $customer['slug'] = $slug;
        }

        // if ($request->has('deleteImage')) {
        //     $deleteImage = $request->deleteImage;
        //     // try {
        //     //     Storage::disk('public')->delete($deleteImage);
        //     // } catch(\Exception $e) {
        //     //     throw $e;
        //     // }
        //     // $imagesAttached = collect(explode(",", $detail['image']));
        //     // $fileNames = $imagesAttached->filter(function($key, $value) use ($deleteImage) {
        //     //     return $value !== $deleteImage;
        //     // });
        //     // $fileNamesDB = $fileNames->implode(',');
        //     $detail['image'] = $deleteImage;

        // }

        if ($customer->isClean() && $detail->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $detail->save();
        $customer->save();

        return $this->showOne($customer, Response::HTTP_OK);
    }

    public function destroy(Customer $customer)
    {
        //TODO Реализовать удаление Customer при отсутствии Users

        if (!$customer->users->isEmpty()) {
            return response()->json(['message' => 'The entry can\'t be deleted!'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $customer->detail->delete();
        $customer->delete();

        return $this->showOne($customer, Response::HTTP_OK);

    }

    protected function getSlug($title) {
        return Str::slug(trim(strtolower($title)));
    }
}
