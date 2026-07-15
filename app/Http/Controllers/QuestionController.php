<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\QuestionComment;
use App\Models\QuestionTag;
use App\Models\Tag;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function home()
    {
        $userId = Auth::id();
        $slug =request()->tag;
        $questions = Question::with('user', 'comment', 'like', 'qsave', 'tag')
        
        //count of user lilke,comment,ect
        ->withCount('like', 'comment', 'qsave')
        
        //filter by tags
        ->when($slug,function ($query, $slug) {
            return $query->whereHas('tag',function ($qua) use($slug) {
                $qua->where('slug',$slug);
            });
        })
        
        //user is like or not 
        ->withExists(['like as is_Like' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])

        ->orderBy('is_fixed','desc')
        ->latest()
        ->paginate(3)->withQueryString();
        return Inertia::render('Home', ['questions' => $questions]);
    }

    public function details($slug)
    {
        $userId = Auth::id();

        $ques = Question::where('slug', $slug)->with('comment.user', 'user','tag')->withCount('like', 'comment', 'qsave')->withExists(['like as is_Like' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->firstOrFail();
        return Inertia::render('QuestionDetail', ['ques' => $ques]);
    }

    public function like_handle($id)
    {
        $user = Auth::id();
        $questionLike = Question::findOrFail($id);

        $isLike = $questionLike->like()->toggle($user);
        $like = count($isLike['attached']) > 0;
        $questionLike->loadCount('like');
        $likeCount = $questionLike->like_count;
        return response()->json([
            'is_like' => $like,
            'like_count' => $likeCount
        ]);
    }

    public function comment_create(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = QuestionComment::create([
            'user_id' => Auth::id(),
            'question_id' => $id,
            'comment' => $request->comment
        ]);
        $commentCount = QuestionComment::where('question_id', $id)->count();
        $comment->load('user');
        return response()->json([
            'comment' => $comment,
            'comment_count' => $commentCount
        ]);
    }

    public function create_question()
    {
        return Inertia::render('QuestionCreate');
    }

    public function store_question(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tag_id'      => 'required|array',
        ]);

        $question = Question::create([
            'user_id' => $userId,
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'description' => $request->description
        ]);
        $question->tag()->attach($request->tag_id);
        return response()->json([
            'success'  => true,
            'message'  => 'Question submitted successfully!',
            'question' => $question
        ]);
    }

    public function question_owner()
    {
        $userId = Auth::id();
        // $questions =Question::where('user_id',Auth::id())->get();
        $questions = Auth::user()->questions()->with(['user', 'comment'])->withCount('like', 'comment', 'qsave')->withExists(['like as is_Like' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->latest()->get();
        return Inertia::render('Question', ['questions' => $questions]);
    }

    public function delete_question($id)
    {
        $ques = Question::findOrFail($id);
        $ques->delete();
        return response()->json(['success' => 'Success deleting ur question']);
    }

    //still not working
     public function search_question(Request $request, $search)
    {
        $userId = Auth::id();
        $questions = Question::with('user', 'comment', 'like', 'qsave', 'tag')
        ->withCount('like', 'comment', 'qsave')
        ->withExists(['like as is_Like' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
        ->when($search, function ($query, $search) {
            return $query->where(function ($qua) use ($search) {
                $qua->where('title', 'like', '%' . $search . '%')
                   ->orWhere('description', 'like', '%' . $search . '%');
            });
        })->get();

        return response()->json([
            'success' => true,
            'questions' => $questions
        ], 200);
    }

    public function edit_comment($id)
    {
        $comment=QuestionComment::find($id);
        
        $comment->comment=request()->comment;
$comment->save();
        return response()->json(['success'=>'Update Comment']);
    }

    public function delete_comment($id)
    {
         $comment=QuestionComment::find($id);
         $comment->delete();
         return response()->json(['success'=>'Success delete']);
    }

    public function edit_question(Request $request,$id)
    {
        $question =Question::with('tag')->find($id);
        return Inertia::render('QuestionUpdate',['question'=>$question]);
    }

    public function question_update(Request $request,$id)
    {
        $userId=Auth::id();
        $question =Question::find($id);
        $question->update([
            'user_id'=>$userId,
            'slug' => Str::slug($request->title),
            'title'=>$request->title,
            'description'=>$request->description
        ]);
        $question->tag()->sync($request->tag_id);
        $question->load('tag');
        return redirect()->route('home');
    }

    public function question_fix($id)
    {
        $question =Question::find($id);
         $question->is_fixed = !$question->is_fixed;
         $question->save();
        return redirect()->back();
    }

}
