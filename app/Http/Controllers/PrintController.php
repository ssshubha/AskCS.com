<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;

use PDF;
use App\User;
use App\Posts;
class PrintController extends Controller
{
    public function index()
    {	
        $dnldname=sprintf('PostReport-on-%s.pdf',date('c'));
    	$data['allposts'] = Posts::where('active',1)->orderBy('created_at','desc')->paginate(30);
    	//page heading
    	
    	//return home.blade.php template from resources/views folder
    	//return view('home')->withPosts($posts)->withTitle($title);
       	$pdf = PDF::loadView('PrintView',$data);
        //return $pdf->stream('test.pdf'); //this code is used for the name pdf
        return $pdf->stream($dnldname);
    }
}
