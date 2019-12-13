<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function projects()
    {
        $projects = Project::notArchive()->evaluated()->get();

        return view('admin.reports.project', compact('projects'));
    }

    public function showProject(int $project)
    {
        $project = Project::findOrFail($project);

        return view('admin.reports.show-project', compact('project'));
    }

    public function exportCategory(int $id) {
        $category = ProjectCategory::findOrFail($id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$abc = ['J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        $sheet->setCellValue('A1', 'ID');

        $rows = 2;
        foreach($category->projects()->evaluated()->get() as $project){
            $sheet->setCellValue('A' . $rows, $project->id);

            $rows++;
        }
//        foreach(range('A','T') as $columnID) {
//            $sheet->getColumnDimension($columnID)
//                ->setAutoSize(true);
//        }

        $writer = new Xlsx($spreadsheet);

        $date = (new \DateTime())->format('d-m-Y_H_i_s');

        $writer->save('storage/exports/category_report_'.$date.'.xlsx');

        return redirect()->to('storage/exports/category_report_'.$date.'.xlsx');
    }

    public function exportProject(int $id) {

    }

    public function exportExpert(int $id) {

    }
}
