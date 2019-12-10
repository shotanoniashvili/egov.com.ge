<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\RegionRequest;
use App\Models\ProjectCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ReportsController extends JoshController
{
    public function categories()
    {
        $categories = ProjectCategory::all();

        return view('admin.reports.category', compact('categories'));
    }

    public function showCategory(int $category)
    {
        $category = ProjectCategory::findOrFail($category);

        return view('admin.reports.show-category', compact('category'));
    }

    public function experts()
    {
        $experts = User::whereHas('roles', function($query) {
            $query->where('slug', 'expert');
        })->get();

        return view('admin.reports.expert', compact('experts'));
    }

    public function showExpert(int $expert)
    {
        $expert = User::findOrFail($expert);

        return view('admin.reports.show-expert', compact('expert'));
    }
}
