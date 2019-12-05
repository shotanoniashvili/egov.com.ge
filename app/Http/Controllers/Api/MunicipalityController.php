<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\MunicipalityResource;
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

class MunicipalityController extends JoshController
{
    /**
     * Display the specified resource.
     *
     * @param int $municipality
     * @return MunicipalityResource
     */
    public function show(int $municipality)
    {
        $municipality = Municipality::findOrFail($municipality);

        return new MunicipalityResource($municipality);
    }
}
