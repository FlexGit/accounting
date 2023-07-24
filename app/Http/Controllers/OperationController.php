<?php

namespace App\Http\Controllers;

use App\Operation;
use App\Optype;
use App\Opcat;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller {
	private $request;
	
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
    public function index() {
		$years = [];
		for ($i = 2020;$i <= date("Y") + 1;$i++) {
			$years[] = $i;
		}
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
        return view('operation.index')
			->with('years', $years)
			->with('months', $months);
    }
	
    public function getOperationListAjax() {
		$year = $this->request->get('year');
		$month = $this->request->get('month');
		
		$result = DB::table('operations')
			->join('operation_types', 'operation_types.id', '=', 'operations.optype_id')
			->leftjoin('operation_categories', 'operation_categories.id', '=', 'operations.opcat_id')
			->select('operations.*', 'operation_types.name as optype', 'operation_types.alias', 'operation_categories.name as opcat')
			->where('operations.year', $year)
			->where('operations.month', $month)
			->orderBy('operations.id', 'desc')
			->get();
		
		$operations = [];
		
		if (!empty($result)) {
			foreach ($result as $row) {
				if (!isset($operations['total'])) {
					$operations['total'] = 0;
				}
				if ($row->alias == 'expenses') $row->opsum = -1 * $row->opsum;
				$operations['rows'][$row->id]['opsum'] = $row->opsum;
				$operations['rows'][$row->id]['percent'] = $row->percent;
				$operations['rows'][$row->id]['is_accrued'] = $row->is_accrued;
				$operations['rows'][$row->id]['revaluationType'] = $row->revaluationType;
				$operations['rows'][$row->id]['optype'] = $row->optype;
				$operations['rows'][$row->id]['opcat'] = $row->opcat;
				$operations['rows'][$row->id]['comment'] = $row->comment;
				$operations['rows'][$row->id]['created_at'] = $row->created_at;
				if (!in_array($row->alias, ['loan', 'deposit'])) {
					$operations['total'] += $row->opsum;
				}
			}
		}
		$VIEW = view('operation.list', compact('operations'));
		return response()->json(['status' => 'success', 'data' => strval($VIEW)]);
	}

    public function edit() {
		$operationId = intval($this->request->get('operationId'));
	
		$result = DB::table('operation_categories')
			->select('operation_categories.*')
			->orderBy('operation_categories.name')
			->get();
	
		$categories = [];
	
		if (!empty($result)) {
			foreach ($result as $row) {
				$categories[$row->id] = $row->name;
			}
		}

		$result = [];
		if ($operationId) {
			$result = Operation::find($operationId)->toArray();
		}
	
		$optypes = Optype::get()->toArray();
		
        return view('operation.edit')
			->with('operation', $result)
			->with('optypes', $optypes)
			->with('categories', $categories);
    }

    public function save() {
		$operationId = intval($this->request->get('operationId'));

		if ($operationId) {
			$operation = Operation::findOrFail($operationId);
		} else {
			$operation = new Operation;
		}
		
		$operation->optype_id = intval($this->request->optypeId);
		$operation->opcat_id = intval($this->request->opcatId);
		$operation->opsum = $this->request->opsum;
		$operation->is_accrued = $this->request->isAccrued;
		$operation->comment = $this->request->comment;
		$operation->year = $this->request->year;
		$operation->month = $this->request->month;
		$operation->save();

		return response()->json(['status' => 'success', 'operationId' => $operation->id]);
    }

    public function delete() {
		$operationId = intval($this->request->get('operationId'));
		if (!$operationId) return response()->json(['status' => 'error', 'reason' => 'Операции не существует!']);
		
		Operation::destroy($operationId);
	
		return response()->json(['status' => 'success']);
    }
}
