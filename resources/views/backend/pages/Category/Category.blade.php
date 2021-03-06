@extends('backend.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Category List</h1>
    <a class="btn btn-success" href="{{route('category.form')}}">Create New Category</a>
</div>
<div class="row">
  <div class="col-md-12 table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Category name</th>
            <th scope="col">Details</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($categories as $key=>$category)
          <tr>
            <th scope="row">{{$key+1}}</th>
            <th scope="row">{{$category->name}}</th>
            <th scope="row">{{$category->details}}</th>
            <th scope="row">

            <a class="btn btn-primary mb-2" href="{{route('category.edit',$category->id)}}">Edit</a>
            <a class="btn btn-danger" href="{{route('category.delete',$category->id)}}">Delete</a>
              
            </th>

          </tr>
        @endforeach

        </tbody>
      </table>
  </div>
</div>
@endsection

