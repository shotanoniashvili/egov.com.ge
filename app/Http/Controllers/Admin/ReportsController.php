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

        $sheet->setCellValue('A1', 'პროექტის დასახელება');
        $sheet->setCellValue('B1', 'მუნიციპალიტეტი');
        $sheet->setCellValue('C1', 'ექსპერტი');
        $sheet->setCellValue('D1', 'წარმატებული');
        $sheet->setCellValue('E1', 'გამჭვირვალე');
        $sheet->setCellValue('F1', 'ადეკვატური');
        $sheet->setCellValue('G1', 'გაზიარებადი');
        $sheet->setCellValue('H1', 'მდგრადი');
        $sheet->setCellValue('I1', 'ჯამური ქულა');
        $sheet->setCellValue('J1', 'შეფასების თარიღი');

        $rows = 2;
        foreach($category->projects()->evaluated()->get() as $project){
            $sheet->setCellValue('A' . $rows, $project->title);
            $sheet->setCellValue('B' . $rows, $project->municipality->name);

            foreach($project->getEvaluatedExperts() as $expert) {
                $sheet->setCellValue('C' . $rows, $expert->fullname);
                $sheet->setCellValue('D' . $rows, $project->evaluations()->expert($expert->id)->success()->sum('subevaluations.point'));
                $sheet->setCellValue('E' . $rows, $project->evaluations()->expert($expert->id)->transparent()->sum('subevaluations.point'));
                $sheet->setCellValue('F' . $rows, $project->evaluations()->expert($expert->id)->adequate()->sum('subevaluations.point'));
                $sheet->setCellValue('G' . $rows, $project->evaluations()->expert($expert->id)->shareable()->sum('subevaluations.point'));
                $sheet->setCellValue('H' . $rows, $project->evaluations()->expert($expert->id)->sustainable()->sum('subevaluations.point'));
                $sheet->setCellValue('I' . $rows, $project->getRatingSumByExpert($expert->id));
                $sheet->setCellValue('J' . $rows, $project->evaluations()->expert($expert->id)->first()->created_at->format('d-m-Y H:i:s'));

                $rows++;
            }
            $rows++;
        }
        foreach(range('A','J') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $date = (new \DateTime())->format('d-m-Y_H_i_s');
        $writer->save('storage/exports/category_report_'.$date.'.xlsx');

        return redirect()->to('storage/exports/category_report_'.$date.'.xlsx');
    }

    public function exportProject(int $id) {
        $project = Project::findOrFail($id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$abc = ['J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        $sheet->setCellValue('A1', 'პროექტის დასახელება');
        $sheet->setCellValue('B1', 'მუნიციპალიტეტი');

        $sheet->setCellValue('A2', $project->title);
        $sheet->setCellValue('B2', $project->municipality->name);

        $sheet->setCellValue('A4', 'ექსპერტი');
        $sheet->setCellValue('B4', 'წარმატებული');
        $sheet->setCellValue('C4', 'გამჭვირვალე');
        $sheet->setCellValue('D4', 'ადეკვატური');
        $sheet->setCellValue('E4', 'გაზიარებადი');
        $sheet->setCellValue('F4', 'მდგრადი');
        $sheet->setCellValue('G4', 'ჯამური ქულა');
        $sheet->setCellValue('H4', 'შეფასების თარიღი');

        $rows = 5;
        foreach($project->getEvaluatedExperts() as $expert) {
            $sheet->setCellValue('A' . $rows, $expert->fullname);
            $sheet->setCellValue('B' . $rows, $project->evaluations()->expert($expert->id)->success()->sum('subevaluations.point'));
            $sheet->setCellValue('C' . $rows, $project->evaluations()->expert($expert->id)->transparent()->sum('subevaluations.point'));
            $sheet->setCellValue('D' . $rows, $project->evaluations()->expert($expert->id)->adequate()->sum('subevaluations.point'));
            $sheet->setCellValue('E' . $rows, $project->evaluations()->expert($expert->id)->shareable()->sum('subevaluations.point'));
            $sheet->setCellValue('F' . $rows, $project->evaluations()->expert($expert->id)->sustainable()->sum('subevaluations.point'));
            $sheet->setCellValue('G' . $rows, $project->getRatingSumByExpert($expert->id));
            $sheet->setCellValue('H' . $rows, $project->evaluations()->expert($expert->id)->first()->created_at->format('d-m-Y H:i:s'));

            $rows++;
        }

        foreach(range('A','H') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $date = (new \DateTime())->format('d-m-Y_H_i_s');
        $writer->save('storage/exports/project_report_'.$date.'.xlsx');

        return redirect()->to('storage/exports/project_report_'.$date.'.xlsx');
    }

    public function exportExpert(int $id) {
        $expert = User::findOrFail($id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //$abc = ['J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        $sheet->setCellValue('A1', 'პროექტის დასახელება');
        $sheet->setCellValue('B1', 'მუნიციპალიტეტი');
        $sheet->setCellValue('C1', 'წარმატებული');
        $sheet->setCellValue('D1', 'გამჭვირვალე');
        $sheet->setCellValue('E1', 'ადეკვატური');
        $sheet->setCellValue('F1', 'გაზიარებადი');
        $sheet->setCellValue('G1', 'მდგრადი');
        $sheet->setCellValue('H1', 'ჯამური ქულა');
        $sheet->setCellValue('I1', 'შეფასების თარიღი');

        $rows = 2;
        foreach($expert->getEvaluatedProjects() as $project) {
            $sheet->setCellValue('A' . $rows, $project->title);
            $sheet->setCellValue('B' . $rows, $project->municipality->name);
            $sheet->setCellValue('C' . $rows, $project->evaluations()->expert($expert->id)->success()->sum('subevaluations.point'));
            $sheet->setCellValue('D' . $rows, $project->evaluations()->expert($expert->id)->transparent()->sum('subevaluations.point'));
            $sheet->setCellValue('E' . $rows, $project->evaluations()->expert($expert->id)->adequate()->sum('subevaluations.point'));
            $sheet->setCellValue('F' . $rows, $project->evaluations()->expert($expert->id)->shareable()->sum('subevaluations.point'));
            $sheet->setCellValue('G' . $rows, $project->evaluations()->expert($expert->id)->sustainable()->sum('subevaluations.point'));
            $sheet->setCellValue('H' . $rows, $project->getRatingSumByExpert($expert->id));
            $sheet->setCellValue('I' . $rows, $project->evaluations()->expert($expert->id)->first()->created_at->format('d-m-Y H:i:s'));

            $rows++;
        }

        foreach(range('A','I') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $date = (new \DateTime())->format('d-m-Y_H_i_s');
        $writer->save('storage/exports/expert_report_'.$date.'.xlsx');

        return redirect()->to('storage/exports/expert_report_'.$date.'.xlsx');
    }
}
