<?php

namespace App\Admin\Home;

use App\Admin\Advertisements\Advertisement;
use App\Admin\ContactUs\ContactUs;
use App\Admin\Users\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\InfoBox;
use App\Admin\Cities\City;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('الاحصائيات');

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $users = User::count();
                    $infoBox = new InfoBox('المستخدمين', 'users', 'green', '/admin/users', $users);
                    $column->append($infoBox->render());
                });

                $row->column(4, function (Column $column) {
                    $data = Advertisement::count();
                    $infoBox = new InfoBox('الاعلانات', 'buysellads', 'red', '/admin/advertisements', $data);
                    $column->append($infoBox->render());
                });

                $row->column(4, function (Column $column) {
                    $data = City::count();
                    $infoBox = new InfoBox('المدن', 'map', 'red', '/admin/cities', $data);
                    $column->append($infoBox->render());
                });

            });
            $content->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $users = User::whereBetween('created_at', [Carbon::now()->subMonths(5)->format('Y-m-d'), Carbon::now()->format('Y-m-d')])->get(['created_at', 'id'])
                    
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->created_at)->format('m'); // grouping by years
                    })->all();
                    $y = [];
                    $x = [];
                    foreach ($users as $key => $value) {
                        $y[] = $value->count();
                        $x[] = date("F", mktime(0, 0, 0, intval($key), 10));
                    }

                    $column->append(view('vendor.charts.report', [
                        'x_axis' => json_encode($x),
                        'y_axis' => json_encode($y),
                        'label' => 'المستخدمين المسجلين',
                        'type' => 'bar',
                        'id' => 2,
                    ])->render());
                });
            });
        });
    }
}
