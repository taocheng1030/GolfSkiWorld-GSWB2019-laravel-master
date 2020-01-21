<?php
namespace App\Traits;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait Controllers
{
    /**
     * Paginate a laravel collection or array of items.
     *
     * @param  array|\Illuminate\Support\Collection $items    array to paginate
     * @param  int $perPage number of pages
     * @return \Illuminate\Pagination\LengthAwarePaginator    new LengthAwarePaginator instance
     */
    public function paginate($items, $perPage)
    {
        if(is_array($items)){
            $items = collect($items);
        }

        $currentPage = Paginator::resolveCurrentPage();
        return new LengthAwarePaginator(
            $items->forPage($currentPage, $perPage),
            $items->count(), $perPage, $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }


    /**
     * Clear response by pagination $data
     *
     * @param $response
     * @param string $responseKey
     * @param string $relationName
     * @return mixed
     */
    private function clear($response, $responseKey = 'data', $relationName = 'owner')
    {
        foreach ($response[$responseKey] as $key => $items) {
            foreach ($items as $rel => $item) {
                if (is_array($item)) {
                    if(empty($item) || $rel == 'videos' || $rel == 'photos') {
                        unset($response[$responseKey][$key][$rel]);
                    } else {
                        if ($relationName) {
                            $response[$responseKey][$key][$relationName] = $item[0];
                        }
                        unset($response[$responseKey][$key][$rel]);
                        unset($response[$responseKey][$key][$relationName]['pivot']);
                    }
                }
            }
        }

        return $response;
    }

    /**
     * Prepare sorting on page
     */
    public function getSortingParams()
    {
        if ($sort = $this->request->get('sort')) {
            if(array_key_exists(strtolower($sort), $this->sorting())) {
                $sort = explode('-', $sort);
                if (!empty($sort) && count($sort) > 1) {
                    $this->file->sorting_column = $sort[0];
                    $this->file->sorting_direction = $sort[1];
                    print_r($sort);
                }
            }
        }
    }
}