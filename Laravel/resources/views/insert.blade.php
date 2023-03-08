<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <title>Document</title>
</head>
<body>

<div class='container'>
<h2>create employee</h2>
<div class="col-md-8">



  <form method="post" action="{{ URL::to('store-employee')}}">        {{-- store-employee nam er address e data patabe --}}
    {{ csrf_field()}}                     {{-- server attack theke secure thakte --}}
       <div class="form-group">

        <label for="">name</label>
        <input type="text" class="form-control"  name="name" id="">
       </div>

       <div class="form-group">
        <label for="">email</label>
        <input type="text" class="form-control"  name="email" id="">
    </div>

        <div class="form-group">
            <label for="">address</label>
            <input type="text" class="form-control"   name="address" id="">
        </div>

        <div class="form-group">
            <label for="">age</label>
            <input type="text" class="form-control"   name="age" id="">
        </div>




{{-- //extra --}}

{{-- <div class="form-group">

<label for="">Which Fruit Do you Like</label><br/>
        <input type="checkbox" name="situation" value="Mango"> Mango <br/>
        <input type="checkbox" name="situation" value="Orange"> Orange <br/>
        {{-- <input type="checkbox" name="fruits[]" value="Orange"> Orange <br/>
        <input type="checkbox" name="fruits[]" value="Apple"> Apple <br/>
        <input type="checkbox" name="fruits[]" value="Banana"> Banana <br/>
        <input type="checkbox" name="fruits[]" value="Strawberry"> Strawberry <br/><br/> --}}
    {{-- </div> --}} 

{{-- //extra --}}




<div class="form-group">

        <button  class="btn btn-success" type="submit">Submit</button>
        <a class="btn btn-info" href="{{ URL::to('employees') }}">Back</a>
    </div>
  </form>

</div>
</div>

</body>
</html>
