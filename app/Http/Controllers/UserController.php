<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Posts;
use Illuminate\Http\Request;
use Auth;
use Image;
class UserController extends Controller {
  /*
   * Display active posts of a particular user
   * 
   * @param int $id
   * @return view
   */
  public function user_posts($id)
  {
    //
    $posts = Posts::where('author_id',$id)->where('active',1)->orderBy('created_at','desc')->paginate(5);
    $title = User::find($id)->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }
  /*
   * Display all of the posts of a particular user
   * 
   * @param Request $request
   * @return view
   */
  public function user_drafts($id)
  {
    //
    $posts = Posts::where('author_id',$id)->where('active',0)->orderBy('created_at','desc')->paginate(5);
    $title = User::find($id)->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }
  public function user_posts_all(Request $request)
  {
    //
    $user = $request->user();
    $posts = Posts::where('author_id',$user->id)->orderBy('created_at','desc')->paginate(5);
    $title = $user->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }
  /*
   * Display draft posts of a currently active user
   * 
   * @param Request $request
   * @return view
   */
  public function user_posts_draft(Request $request)
  {
    //
    $user = $request->user();
    $posts = Posts::where('author_id',$user->id)->where('active',0)->orderBy('created_at','desc')->paginate(5);
    $title = $user->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }
  /**
   * profile for user
   */
  public function profile(Request $request, $id) 
  {
    $data['user'] = User::find($id);
    if (!$data['user'])
      return redirect('/');
    if ($request -> user() && $data['user'] -> id == $request -> user() -> id) {
      $data['author'] = true;
    } else {
      $data['author'] = null;
    }
    $data['comments_count'] = $data['user'] -> comments -> count();
    $data['posts_count'] = $data['user'] -> posts -> count();
    $data['posts_active_count'] = $data['user'] -> posts -> where('active', 1) -> count();
    $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
    $data['latest_posts'] = $data['user'] -> posts -> where('active', 1) -> take(5);
    $data['latest_comments'] = $data['user'] -> comments -> take(5);
    return view('admin.profile', $data);
  }
  public function profilephoto(){
      return view('profile', array('user' => Auth::user()) );
    }
    public function update_avatar(Request $request){

      // Handle the user upload of avatar
      if($request->hasFile('avatar')){
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();
      }

      return view('profile', array('user' => Auth::user()) );

    }
    public function searchinfo($str)
    {
      $len=strlen($str);
      $str=$str.'%';
      $posts = Posts::where('active',1)->where('title','LIKE',$str)->paginate(5);
      //$str='he';
      $newstr='';
      if($len>0){
        foreach($posts as $post){
            //$anostring="url";
            //$anostring=$anostring."('/'.$post->slug)";
            //$newstr=$newstr."<br /><a href=".$anostring.$post->title . "</a>";
            //$newstr=$newstr."<a href='"url("/".$post->slug)">'.$post->title.'</a><br>';
            //<a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
            $newstr=$newstr.'<a href="'.'/'.$post->slug.'"'.'>'.$post->title. '</a><br>';
            //$newstr=$newstr.$post->title."<br>";
            //http://localhost:8000/url(/laravel3)
        }
      }

      return $newstr;
    }

    public function searchinfouser($str)
    {
      $len=strlen($str);
      $str=$str.'%';
      $usesrs = User::where('name','LIKE',$str)->paginate(5);
      //$str='he';
      $newstr='';
      if($len>0){
        foreach($usesrs as $user){
            //$anostring="url";
            //$anostring=$anostring."('/'.$post->slug)";
            //$newstr=$newstr."<br /><a href=".$anostring.$post->title . "</a>";
            //$newstr=$newstr."<a href='"url("/".$post->slug)">'.$post->title.'</a><br>';
            //<a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
            $newstr=$newstr.'<a href="'.'user'.'/'.$user->id.'"'.'>'.$user->name. '</a><br>';
            //$newstr=$newstr.$post->title."<br>";
            //http://localhost:8000/url(/laravel3)
        }
      }

      return $newstr;
    }
}