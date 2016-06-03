<?php

namespace App\Http\Controllers;
use App\Posts;
use App\Comments;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comslugs;

class CommentController extends Controller
{
    //
  public function store(Request $request)
  {
    //on_post, from_user, body
    $comslug=Comslugs::find(1);
    $slugnum=$comslug->slugcount;
    $forslug=(string)$slugnum;
    $comslug->slugcount=$slugnum+1;
    $comslug->save();
    $input['from_user'] = $request->user()->id;
    $input['on_post'] = $request->input('on_post');
    $input['body'] = $request->input('body');
    $input['slug']=$forslug;
    $slug = $request->input('slug');
    Comments::create( $input );
    return redirect($slug)->with('message', 'Comment published');     
  }

  public function edit(Request $request,$slug)
  {
    $comment = Comments::where('slug',$slug)->first();
    if($comment && ($request->user()->id == $comment->author->id || $request->user()->is_admin()))
      return view('comments.edit')->with('comment',$comment);
    return redirect('/')->withErrors('you have not sufficient permissions');
  }

  public function update(Request $request)
  {
    //
    $comment_id = $request->input('comment_id');
    $comment = Comments::find($comment_id);
    $anoslug=$comment->post->slug;
    if($comment && ($comment->author->id == $request->user()->id || $request->user()->is_admin()))
    {
      
      $slug = $comment->slug;
      
      $comment->slug = $slug;
        
      
      
      $comment->body = $request->input('body');
      $message='Comment updated succesfully';
      $comment->save();
      //return redirect('/home')->withMessage($message);
      return redirect($anoslug)->with('message', 'Comment updated successfully'); 
    }
    else
    {
      return redirect($anoslug)->with('message','you have not sufficient permissions');
    }
  }

  public function destroy(Request $request, $id)
  {
    //
    $comment = Comments::find($id);
    $anoslug=$comment->post->slug;
    if($comment && ($comment->author->id == $request->user()->id || $request->user()->is_admin()))
    {
      $comment->delete();
      //$data['message'] = 'Post deleted Successfully';
      return redirect($anoslug)->with('message', 'Comment deleted successfully'); 
    }
    
    return redirect($anoslug)->with('message', 'you have not sufficient permission'); 
  }
}
