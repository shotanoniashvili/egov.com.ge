<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Municipality;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Sentinel;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $abcArray = ['ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ც', 'ძ', 'წ', 'ჭ', 'ხ', 'ჯ', 'ჰ'];

        $query = Municipality::query();
        if(in_array($request->s, $abcArray)) {
            $query->where('name', 'like', $request->s.'%');
        }

        $municipalities = $query->get();

        return view('municipalities.index', compact('municipalities', 'abcArray'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $municipality
     * @return \Illuminate\Http\Response
     */
    public function show(int $municipality)
    {
        $municipality = Municipality::findOrFail($municipality);

        $projects = $municipality->projects()->activeForWeb()->get();

        $categories = ProjectCategory::all();

        $municipalities = Municipality::all();

        return view('municipalities.show', compact('municipality', 'projects', 'categories', 'municipalities'));
    }
}
