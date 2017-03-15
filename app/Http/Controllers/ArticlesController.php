<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use App\Http\Requests\ArticlesRequest;
use Sentinel;
use Session;
use Illuminate\Support\Facades\DB;
use Excel;

class ArticlesController extends Controller
{
    public function __construct() {

      $this->middleware('admin', ['except' => ['index','show']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if($request->ajax()) {
            if($request->keywords) {
                $articles = Article::where('title', 'like', '%'.$request->keywords.'%')
                ->orWhere('content', 'like', '%'.$request->keywords.'%')
                ->paginate(10);
                  $view = (String) view('articles._list')
                  ->with('articles', $articles);
                  return response()->json(['view' => $view]);
            }elseif($request->direction){
                $articles = Article::orderBy('id', $request->direction)
                ->paginate(10);
                $request->direction == 'asc' ? $direction = 'desc' : $direction = 'asc';
                $view = (String)view('articles._list')
                ->with('articles', $articles)
                ->render();
                return response()->json(['view' => $view, 'direction' => $direction]);
            }
        }else{
            $datas = Article::orderBy('id', 'DESC')->paginate(10);
            return view('articles.index')->with('datas', $datas);   
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
        $user = Sentinel::getUser();
        // dd($user);

        $tambah = new Article();
        $tambah->title = $request['title'];
        $tambah->content = $request['content'];
        $tambah->writer = $user->username;
        $tambah->save();

        Session::flash('notice', 'Article has been inserted to database');
        return redirect()->to('/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        $comments = Article::find($id)->comments;
  
        return view('articles.tampil')->with('tampilkan', $article)->with('komen', $comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::where('id', $id)->first();
        return view('articles.edit')->with('article', $article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Sentinel::getUser();
        // dd($user);

        $update = Article::where('id', $id)->first();
        $update->title = $request['title'];
        $update->content = $request['content'];
        $update->writer = $user->username;
        $update->save();

        Session::flash('notice', 'Article has been updated');
        return redirect()->to('/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Article::find($id);
        $hapus->delete();

        Session::flash('notice','Data has been deleted');
        return redirect()->to('/articles');
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
}