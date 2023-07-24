<?php

namespace App\Http\Controllers;

use App\Template;
use App\Opcat;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller {
	private $request;
	
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
    public function index() {
        return view('template.index');
    }
	
    public function getTemplateListAjax() {
		$result = DB::table('operation_templates')
			->join('operation_types', 'operation_types.id', '=', 'operation_templates.optype_id')
			->leftjoin('operation_categories', 'operation_categories.id', '=', 'operation_templates.opcat_id')
			->select('operation_templates.*', 'operation_types.name as optype', 'operation_types.alias', 'operation_categories.name as opcat')
			->orderBy('operation_types.name')
			->orderBy('operation_categories.name')
			->orderBy('operation_templates.name')
			->get();
		
		$templates = [];
		
		if (!empty($result)) {
			foreach ($result as $row) {
				$templates['rows'][$row->id]['name'] = $row->name;
				$templates['rows'][$row->id]['optype'] = $row->optype;
				$templates['rows'][$row->id]['opcat'] = $row->opcat;
				$templates['rows'][$row->id]['default_value'] = $row->default_value;
				$templates['rows'][$row->id]['created_at'] = $row->created_at;
			}
		}
		$VIEW = view('template.list', compact('templates'));
		return response()->json(['status' => 'success', 'data' => strval($VIEW)]);
	}
	
	public function getTemplateListControlAjax() {
		$optypeId = $this->request->get('optypeId');
		
		//DB::connection()->enableQueryLog();
		$result = Template::where('optype_id', $optypeId)
			->orderBy('name')
			->get();
		//\Log::debug(DB::getQueryLog());
		
		$templates = [];
		
		if (!empty($result)) {
			$i = 0;
			foreach ($result as $row) {
				$templates[$i]['id'] = $row->id;
				$templates[$i]['name'] = $row->name;
				$templates[$i]['default_value'] = $row->default_value;
				$i ++;
			}
		}
		//\Log::debug($templates);
		return response()->json(['status' => 'success', 'values' => $templates]);
	}
	
	public function edit() {
		$templateId = intval($this->request->get('templateId'));
		
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
		if ($templateId) {
			$result = Template::find($templateId)->toArray();
		}
		
		return view('template.edit')
			->with('template', $result)
			->with('categories', $categories);
	}
	
	public function save() {
		$templateId = intval($this->request->get('templateId'));
		
		if ($templateId) {
			$template = Template::findOrFail($templateId);
		} else {
			$template = new Template;
		}
		
		$template->optype_id = intval($this->request->optypeId);
		$template->opcat_id = intval($this->request->opcatId);
		$template->name = $this->request->name;
		$template->default_value = $this->request->defaultValue;
		$template->save();
		
		return response()->json(['status' => 'success', 'templateId' => $template->id]);
	}
	
	public function delete() {
		$templateId = intval($this->request->get('templateId'));
		if (!$templateId) return response()->json(['status' => 'error', 'reason' => 'Шаблона не существует!']);
		
		Template::destroy($templateId);
		
		return response()->json(['status' => 'success']);
	}
}
