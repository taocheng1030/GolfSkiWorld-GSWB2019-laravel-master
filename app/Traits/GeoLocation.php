<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait GeoLocation
{
    use Validation, Find;

    /**
     * Getting geo coordinates
     *
     * @param  object $request
     * @return object $model
     */
    public function withCoordinates($request)
    {
        $latLong = $this->validateCredentials($request, [
            'longMin' => 'required|numeric',
            'longMax' => 'required|numeric',
            'latMin'  => 'required|numeric',
            'latMax'  => 'required|numeric',
        ]);

        return $this->model
            ->where('longitude', '>=', $latLong['longMin'])
            ->where('longitude', '<=', $latLong['longMax'])
            ->where('latitude',  '>=', $latLong['latMin'])
            ->where('latitude',  '<=', $latLong['latMax']);
    }

    /**
     * Find some model by ID
     *
     * @param integer $id
     * @return object $model
     */
    public function find($id)
    {
        $model = $this->model;
        $model = $model::where('id', $id)
            ->where('published', true)
            ->first();

        if ($model) {
            $model->load($this->relations);
        }

        return $model;
    }

    /**
     * Find all model by geo coordinates
     *
     * @param object Request $request
     * @return array of models
     */
    public function byCoordinates(Request $request)
    {
        $model = $this->withCoordinates($request)->where('published', true);

        if ($types = $request->get('type')) {
            $types = explode(',', $types);
            if (count($types) == 0)
                return [];

            $selectors = [];
            foreach ($types as $type) {
                $type = explode('-', $type);
                if (count($type) < 2)
                    return [];

                if (isset($this->typeSelector[$type[0]])) {
                    $selectors[$type[0]][$this->typeSelector[$type[0]]['field']][] = $type[1];
                } else {
                    $selectors[$type[0]] = [];
                }
            }

            if (count($selectors) == 0)
                return [];

            $count = 0;
            foreach ($selectors as $key => $selector) {
                if (isset($this->typeSelector[$key])) {
                    $count++;
                }
            }

            if ($count == 0)
                return [];

            foreach ($selectors as $selector) {
                $model->where(function ($q) use ($selector) {
                    foreach ($selector as $field => $types) {
                        foreach ($types as $key => $type) {
                            if ($key == 0) {
                                $q->where($field, $type);
                            } else {
                                $q->orWhere($field, $type);
                            }
                        }
                    }
                });
            }
        }

        if ($name = $request->get('name')) {
            $model->where('name', 'LIKE', '%' . $name . '%');
        }

        $load = [];
        foreach ($this->typeSelector as $item) {
            $load[] = $item['relation'];
        }

        return $model
            ->get($this->baseItems)
            ->load($load)
            ->each(function ($row) {
                $row->setHidden(['locale']);
            })
            ->toArray();
    }

    /**
     * Get all types for model by relations
     *
     * @return array of types
     */
    public function getTypes()
    {
        $types = [];
        foreach ($this->typeSelector as $typeSelector) {
            $type = $typeSelector['relation'];
            $type = $this->model->$type()->getRelated();
            foreach ($type::all() as $type) {
                $types[] = [
                    'id' => strtolower($typeSelector['name']) . '-' . $type->id,
                    'name' => $type->name
                ];
            }
        }

        return $types;
    }
}
