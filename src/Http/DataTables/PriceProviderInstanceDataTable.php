<?php

namespace RecursiveTree\Seat\PricesCore\Http\DataTables;

use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;
use Yajra\DataTables\Services\DataTable;

class PriceProviderInstanceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajax(): \Illuminate\Http\JsonResponse
    {
        $backends = config('priceproviders.backends');

        return datatables()
            ->eloquent($this->applyScopes($this->query()))
            ->editColumn('backend', function ($row) use ($backends) {
                $info = $backends[$row->backend] ?? [];
                return sprintf("%s (%s)",trans($info['label'] ?? 'web::seat.unknown'), trans($info['plugin'] ?? 'pricescore::settings.unknown_plugin'));
            })
            ->addColumn('actions', function ($row){
                return view('pricescore::instance.actions',['id'=>$row->id])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()->columns($this->getColumns());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return PriceProviderInstance::query();
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return [
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'backend', 'title' => 'Backend'],
            ['data' => 'actions', 'title'=> 'Actions', 'className'=>'text-right'],
        ];
    }
}