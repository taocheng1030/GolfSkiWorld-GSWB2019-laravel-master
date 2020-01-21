<?php
namespace App\Traits;

use Route;
use Illuminate\Support\Facades\Input;

trait Filter
{
    protected $temporaryTable;

    protected static $icons = [
        'asc'  => '<i class="fa fa-sort-alpha-asc"></i>',
        'desc' => '<i class="fa fa-sort-alpha-desc"></i>'
    ];

    public function scopeSortable($query)
    {
        if (is_null($this->sortable))
            return $query;

        if (Input::has('field') && Input::has('order'))
        {
            $field = Input::get('field');
            $order = Input::get('order');

            if (array_key_exists($field, $this->sortable) && in_array($order, ['asc', 'desc'])) {
                return $query->orderBy($this->sortable[$field], $order);
            }
        }

        return $query;
    }

    public function scopeFilterable($query)
    {
        if (is_null($this->sortable))
            return $query;

        if (Input::has('filter'))
        {
            $filter = Input::get('filter');
            if (!is_array($filter))
                return $query;

            foreach ($filter as $field => $value) {
                if (array_key_exists($field, $this->sortable)) {
                    if ($value != '') {
                        if (in_array($this->sortable[$field], $this->searchable)) {
                            $query->where($this->sortable[$field], 'like', '%'.$value.'%');
                        } else {
                            $query->where($this->sortable[$field], $value);
                        }
                    }
                }
            }

            return $query;
        }

        return $query;
    }

    public function scopeJoinLocation($query)
    {
        return $query->with(['city', 'state', 'country'])
            ->leftJoin('cities', 'cities.id', '=', $this->getTable().'.city_id')
            ->leftJoin('states', 'states.id', '=', $this->getTable().'.state_id')
            ->leftJoin('countries', 'countries.id', '=', $this->getTable().'.country_id');
    }

    public function scopeJoinRole($query)
    {
        return $query->with('roles')
            ->leftJoin('role_user', 'role_user.user_id', '=', $this->getTable().'.id');
    }

    public function scopeJoinLanguage($query)
    {
        return $query->with('language')
            ->leftJoin('languages', 'languages.id', '=', $this->getTable().'.language_id');
    }

    public function scopeJoinSite($query)
    {
        return $query->with('site')
            ->leftJoin('sites', 'sites.id', '=', $this->getTable().'.site_id');
    }

    public function scopeJoinType($query)
    {
        return $query->with('type')
            ->leftJoin($this->temporaryTable, $this->temporaryTable.'.id', '=', $this->getTable().'.type_id');
    }

    public function scopeJoinLimiter($query)
    {
        return $query->with('limiter')
            ->leftJoin($this->temporaryTable, $this->temporaryTable.'.id', '=', $this->getTable().'.limiter_id');
    }

    public function filter($filters, $perPage)
    {
        $model = $this::select($this->getTable().'.*');

        foreach ($filters as $filter) {
            if (is_array($filter)) {
                $this->temporaryTable = $filter['table'];
                $method = $filter['scope'];

                $model->$method();
            } else {
                $model->$filter();
            }
        }

        return $model->filterable()->sortable()->paginate($perPage);
    }

    public static function link_to_sorting_action($col, $title = null)
    {
        if (is_null($title)) {
            $title = str_replace('_', ' ', $col);
            $title = ucfirst($title);
        }

        $field = Input::get('field');
        $order = Input::get('order');

        $indicator = ($field == $col ? ($order === 'desc' ? self::$icons['desc'] : self::$icons['asc']) : null);
        $parameters = array_merge(Input::get(), ['field' => $col, 'order' => ($order === 'desc' ? 'asc' : 'desc')]);

        return \HTML::decode(link_to_route(Route::currentRouteName(), "$title $indicator", $parameters));
    }
}