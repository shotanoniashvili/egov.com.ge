<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\RegionResource;
use App\Models\Municipality;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Sentinel;

class RegionController extends JoshController
{
    /**
     * Display the specified resource.
     *
     * @param int $region
     * @return RegionResource
     */
    public function show(int $region)
    {
        $region = Region::with('municipalities')->where('id', $region)->firstOrFail();

        return new RegionResource($region);
    }
}
