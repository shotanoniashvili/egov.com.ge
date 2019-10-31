<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\RegionResource;
use App\Models\Municipality;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Rate;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Sentinel;

class ProjectCategoryController extends JoshController
{
    /**
     * Display the specified resource.
     */
    public function getCategoriesForRates()
    {
        $rates = Rate::all()->pluck('project_category_id')->toArray();

        $projectCategories = ProjectCategory::whereNotIn('id', $rates)->get();

        return response()->json(['data' => $projectCategories]);
    }
}
