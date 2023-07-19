<?php

namespace App\Exports;

use App\Models\Admin;
use App\Models\Menu;
use App\Models\News;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NewsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            '_id',
            '開始日期',
            '結束日期',
            '選單名稱',
            '狀態',
            '標題'
        ];
    }

    public function map($news): array
    {
        return [
            $news->_id,
            $news->start_at,
            $news->end_at,
            Menu::where('_id', $news->menu_id)->first()->name,
            $news->status === 1 ? '顯示' : '隱藏',
            $news->title
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $query = News::query();

        if ($this->request->has('menuId')) {
            $menu = $this->request->input('menuId');
            $query->where('menu_id', '=', $menu);
        }

        if ($this->request->has('areaId')) {
            $area = $this->request->input('areaId');
            $query->where('area_id', '=', $area);
        }

        if ($this->request->has('status')) {
            $status = $this->request->input('status');
            $query->where('status', '=', $status);
        }

        if ($this->request->has('title')) {
            $title = $this->request->input('title');
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($this->request->has('perPage')) {
            $perPage = $this->request->input('perPage');
        }

        // 過濾使用者可以看到的區域
        $userId = auth()->user()->_id;
        $role_permission_id = Admin::where('_id', $userId)->first()->role_permission_id;
        $area_permission_id = RolePermission::where('_id', $role_permission_id)->first()->area_permission_id;
        $query->whereIn('area_id', $area_permission_id);

        // 過濾'_id','開始日期','結束日期','選單名稱','狀態','標題'
        $query->select('_id', 'start_at', 'end_at', 'menu_id', 'status', 'title');

        return $query;
        $collection = $query->get();

        // add $collection[]->area and $collection[]->menu to $collection
        foreach ($collection as $key => $value) {
            $collection[$key]['area'] = $value->area();
            $collection[$key]['menu'] = $value->menu();
        }

        return $collection;
    }
}
