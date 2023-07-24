<?php

namespace App\Http\Controllers;

use App\Operation;
use App\Template;
use App\Optype;
use App\Opcat;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MainController extends Controller {
	private $request;
	
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
    public function index() {
        return view('main.index');
    }
	
    public function getReportAjax() {
		//DB::connection()->enableQueryLog();
		$result = DB::table('operations')
			->join('operation_types', 'operation_types.id', '=', 'operations.optype_id')
			->leftjoin('operation_categories', 'operation_categories.id', '=', 'operations.opcat_id')
			->select(DB::raw('operations.year, operations.month, SUM(operations.opsum) as opsum, operation_types.alias, operation_categories.name as opcat'))
			->groupBy(DB::raw('operations.year, operations.month, operations.optype_id, operations.opcat_id'))
			->orderBy('operations.year', 'desc')
			->orderBy('operations.month', 'desc')
			->orderBy('operation_types.name')
			->orderBy('operation_categories.name')
			->get();
		//\Log::debug(DB::getQueryLog());
		
		$report = $reportSum = [];

		if (!empty($result)) {
			foreach ($result as $row) {
				$period = $row->year . ' ' . $row->month;

				if (!isset($report[$period])) {
					$report[$period] = [];
				}
				
				if (!isset($report[$period]['optype'])) {
					$report[$period]['optype'] = [];
				}
				
				if (!isset($report[$period]['optype'][$row->alias]['opsum'])) {
					$report[$period]['optype'][$row->alias]['opsum'] = 0;
				}
				
				$report[$period]['optype'][$row->alias]['opsum'] += $row->opsum;
				
				if (!isset($report[$period]['optype'][$row->alias]['opcat'])) {
					$report[$period]['optype'][$row->alias]['opcat'] = [];
				}
				
				if (!isset($report[$period]['optype'][$row->alias]['opcat'][$row->opcat])) {
					$report[$period]['optype'][$row->alias]['opcat'][$row->opcat] = [];
				}
				
				if (!isset($report[$period]['optype'][$row->alias]['opcat'][$row->opcat]['opsum'])) {
					$report[$period]['optype'][$row->alias]['opcat'][$row->opcat]['opsum'] = 0;
				}
				
				$report[$period]['optype'][$row->alias]['opcat'][$row->opcat]['opsum'] += $row->opsum;
				
				$report[$period]['balance'] = 0;
				
				$report[$period]['balance'] = $report[$period]['optype']['revaluation']['opsum'] + $report[$period]['optype']['incomes']['opsum'] - $report[$period]['optype']['expenses']['opsum'];
				
				if (!isset($reportSum[$row->alias])) {
					$reportSum[$row->alias] = [];
				}
				if (!isset($reportSum[$row->alias]['opsum'])) {
					$reportSum[$row->alias]['opsum'] = 0;
				}
				$reportSum[$row->alias]['opsum'] += $row->opsum;

				if (!isset($reportSum[$row->alias]['opcat'][$row->opcat]['opsum'])) {
					$reportSum[$row->alias]['opcat'][$row->opcat]['opsum'] = 0;
				}
				$reportSum[$row->alias]['opcat'][$row->opcat]['opsum'] += $row->opsum;
			}
			$reportSum['balance'] = $reportSum['revaluation']['opsum'] + $reportSum['incomes']['opsum'] - $reportSum['expenses']['opsum'];
		}
		
		//\Log::debug($reportSum);
	
		$templates = Template::get()->toArray();
		$optypes = Optype::orderBy('sort')->get()->toArray();
		$months = [
			1 => 'Январь',
			2 => 'Февраль',
			3 => 'Март',
			4 => 'Апрель',
			5 => 'Май',
			6 => 'Июнь',
			7 => 'Июль',
			8 => 'Август',
			9 => 'Сентябрь',
			10 => 'Октябрь',
			11 => 'Ноябрь',
			12 => 'Декабрь'
		];
		
		$VIEW = view('main.report', ['report' => $report, 'reportSum' => $reportSum, 'templates' => $templates, 'optypes' => $optypes, 'months' => $months]);
		return response()->json(['status' => 'success', 'data' => strval($VIEW)]);
	}
}
