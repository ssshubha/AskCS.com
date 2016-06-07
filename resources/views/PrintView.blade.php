<!--
<!DOCTYPE html>

<html>
<head>
    <title>Example</title>
</head>
<body>
    <h1>Hello World!!</h1>
</body>
</html>
-->

<!DOCTYPE html>
<html>
<head>
</head>

<body>




<div  style="position: absolute; left: 20px; text-align: center;">
<h2> AskCS.com</h2>
<img src="ForReportImage/ourlogo.jpg" alt="Long-Road-Symbolic-Learn" style="width:80px;height:80px;">
<h3> Reports on Posts </h3>
</div>





<div style="position: absolute;top:250px;">
<table  border="1" style="width:100%">
  <tr style="text-align: center;">
    <td><h3>Post Title</h3></td>
    <td><h3>Post Author</h3></td>
    <td><h3>Created At</h3></td>
  </tr>
  @foreach($allposts as $allpost)
  @if($allpost->slug!='3')
  
  <tr style="text-align: center;">
    <td>{{$allpost->title}}</td>
    <td>{{$allpost->author->name}}</td>
    <td>{{$allpost->created_at->format('M d,Y \a\t h:i a') }}</td>
  </tr>
  @endif 


  @endforeach
  
 
  
 
</table>
</div>
<div  style="position: absolute; left: 600px; padding-top: 1000px; text-align: center;">
<h2> Signature</h2>
</div>
</body>
</html>
