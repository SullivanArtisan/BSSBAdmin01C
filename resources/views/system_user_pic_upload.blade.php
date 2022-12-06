@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('system_user_add')}}" style="margin-right: 10px;">Back</a>
@show


@section('function_page')
    <div>
        <div class="row">
            <div class="col col-sm-auto">
				<h2 class="text-muted pl-2">Upload User's Picture File</h2>
            </div>
            <div class="col"></div>
        </div>
    </div>
	
    <div class="container mt-5">
		<?php
		 // echo Form::open(array('url' => '/uploadfile','files'=>'true'));
		 // echo 'Select the file to upload.';
		 // echo Form::file('image');
		 // echo Form::submit('Upload File');
		 // echo Form::close();
		?>
        <form action="{{route('uploadfile')}}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
			{{Session::forget(['success']);}}
			@endif
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					  <li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
            <div class="custom-file">
                <input type="file" name="file" id="chooseFile">
				<input id="uploadFile" placeholder="No File" disabled="disabled" />
                <label class="custom-file-label" for="chooseFile" id="uploadPath">Select file</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload File
            </button>
        </form>
    </div>
<!--
@if ($message = Session::get('success'))
	<script>
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const inPath = urlParams.get('uploadPath');
		var uploadPath = document.getElementById('uploadPath');
		uploadPath.innerHTML = inPath;
	</script>
@endif
-->
<script>
	document.getElementById("chooseFile").onchange = function() {
		var pathInArray = this.value.split("\\");
	    document.getElementById("uploadPath").innerHTML = pathInArray[pathInArray.length - 1];
	};
</script>
@endsection
