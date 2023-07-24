<?php

namespace App\Http\Controllers;

use App\Opcat;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {
	private $request;
	
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
    public function index() {
        return view('category.index');
    }
	
    public function getCategoryListAjax() {
		$result = DB::table('operation_categories')
			->select('operation_categories.*')
			->orderBy('operation_categories.name')
			->get();
		
		$categories = [];
		
		if (!empty($result)) {
			foreach ($result as $row) {
				$categories['rows'][$row->id]['name'] = $row->name;
				$categories['rows'][$row->id]['created_at'] = $row->created_at;
			}
		}
		$VIEW = view('category.list', compact('categories'));
		return response()->json(['status' => 'success', 'data' => strval($VIEW)]);
	}
	
	public function getCategoryListControlAjax() {
		//DB::connection()->enableQueryLog();
		$result = Opcat::orderBy('name')
			->get();
		//\Log::debug(DB::getQueryLog());
		
		$categories = [];
		
		if (!empty($result)) {
			foreach ($result as $row) {
				$categories[$row->id]['name'] = $row->name;
			}
		}
		//\Log::debug($categories);
		return response()->json(['status' => 'success', 'values' => $categories]);
	}
	
	public function edit() {
		$opcatId = intval($this->request->get('opcatId'));
		
		$result = [];
		if ($opcatId) {
			$result = Opcat::find($opcatId)->toArray();
		}
		
		return view('category.edit')
			->with('category', $result);
	}
	
	public function save() {
		$opcatId = intval($this->request->get('opcatId'));
		
		if ($opcatId) {
			$opcat = Opcat::findOrFail($opcatId);
		} else {
			$opcat = new Opcat;
		}
		
		$opcat->name = $this->request->name;
		$opcat->save();
		
		return response()->json(['status' => 'success', 'opcatId' => $opcat->id]);
	}
	
	public function delete() {
		$opcatId = intval($this->request->get('opcatId'));
		if (!$opcatId) return response()->json(['status' => 'error', 'reason' => 'Категории не существует!']);
		
		Opcat::destroy($opcatId);
		
		return response()->json(['status' => 'success']);
	}
}
