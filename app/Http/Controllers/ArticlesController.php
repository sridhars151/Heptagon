<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmailJob;

class ArticlesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function isAdmin() {
        return Auth::user()->role === 1 ? true : false;
    }

    public function index(Request $request) {
        $page = $_GET['page'] ?? 1;
        if ($this->isAdmin())
            $list = Article::paginate(2);
        else
            $list = Article::where('created_by', Auth::ID())->paginate(2);

        return view('articles.list')->with(['lists' => $list, 'page' => $page]);
    }

    /**
     * Show the article form
     */
    public function addForm(Request $request) {
        $id = $request->id ?? 0;
        $articleDetails = [];
        if ($id)
            $articleDetails = $this->getArticleDetails($id);
        
        return view('articles.add')->with('data', $articleDetails);
    }

    public function getArticleDetails($id) {
        return Article::where('id', $id)->first();
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        $id = $request->id;
        if ($id) {
            Article::where('id', $id)->update(['title' => $request->title, 'description' => $request->description]);
            $msg = 'Article Updated Successfully';
        }
        else {
            Article::create([
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => Auth::ID()
            ]);
            $msg = 'Article Added Successfully';
        }

        return redirect()->route('article')->with('msg', $msg);
    }

    /**
     * Approve can perform by admin users only. Notification will be sent to all subscribed users
     */
    public function approveArticle(Request $request) {
        $id = $request->id ?? 0;
        if ($id && $this->isAdmin()) {
            Article::where('id', $id)->update(['status' => 1]);
            $this->sendEmailToSubscribers($id);
        }

        return redirect()->route('article')->with('msg', 'Article was approved! And Email sent to all the subscribers');
    }

    /**
     * Add mail in database queue with delay of one minute
     */
    public function sendEmailToSubscribers($id) {
        $articleDetails = $this->getArticleDetails($id);
        $list = Cache::get('users');
        $details = [];
        $article = $articleDetails->title.'<br>'.$articleDetails->description;
        foreach ($list as $key => $value) {
            $content = 'Hi '.$value->name.',<br>Please find the below new article published<br>';
           $details = ['email' => $value->email, 'content' => $content.$article];
           $emailJob = (new SendEmailJob($details))->delay(Carbon::now()->addMinutes(1));
           dispatch($emailJob);
        }
    }
}
