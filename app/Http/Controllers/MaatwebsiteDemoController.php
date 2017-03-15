<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Models\Article;
use DB;
use Excel;
use Session;

class MaatwebsiteDemoController extends Controller
{
    public function importExport()
	{
		return view('iesport');
	}

	public function downloadExcel($type,$id)
	{	
		$articlesData = Article::where('id', '=' ,$id)->get()->toArray();
		
		$commentsData = Article::find($id)->comments->toArray();
		return Excel::create('All_Articles', function($excel) use ($articlesData, $commentsData){
			$excel->sheet('Sheet1', function($sheet) use ($articlesData)
	        {
				$sheet->fromArray($articlesData);

	        });

	        $excel->sheet('sheet2', function($sheet) use ($commentsData)
	        {
				$sheet->fromArray($commentsData);
	        });

		})->download($type);

	}

	public function importExcel()
	{
		if(Input::hasFile('import_file')){
			$path = Input::file('import_file')->getRealPath();
			$data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
			
			})->get();
			$data2 = Excel::selectSheetsByIndex(1)->load($path, function($reader) {
			
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$insert[] = ['title' => $value->title, 'content' => $value->content, 'writer' => $value->writer];
				}

				if(!empty($insert)){
					DB::table('articles')->insert($insert);
					
					$maxId = DB::table('articles')->max('id');
					
					foreach ($data2 as $key => $value) {
						$insert2[] = ['user_id' => $value->user_id,  'article_id' => $maxId, 'comment' => $value->comment, 'created_at' => $value->created_at, 'updated_at' => $value->updated_at];
					}
					
					DB::table('comments')->insert($insert2);		
					Session::flash('notice','Import data success');
					return redirect()->to('/articles');
				}
			}
		}else{
			Session::flash('error','no file choosen');
			return redirect()->to('/articles/create');
		}
		return back();
	}
}