@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop

@section('content')
	
	<div class="content-wrapper">

	    <section class="content-header">
	      <h1>
	        {{ $moduleAction }}
	      </h1>
	      <ol class="breadcrumb">
	        <li class=""><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
	        <li class="active">{{ $moduleAction }}</li>
	      </ol>
	    </section>
	    
	    <section class="content">

	      	<div class="box">
	        	<div class="box-header with-border">
		          	<h3 class="box-title"></h3>
		          	<div class="box-tools pull-right">
		            	<a title="Back to Repository" href="{{ route($modulePath.'.index') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-arrow-left"></i>{{'Back'}}</a>
		          	</div>
	        	</div>
        	 	<form onsubmit="return saveQuestion(this)" action="{{route('repository.update', [ base64_encode(base64_encode($object->id)) ])}}" >
        	 		<input name="_method" type="hidden" value="PUT">
	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Type <span style="color: red">*</span></label>
				                  	<select onchange="getStructure(this)" class="form-control" name="type" >
				                  		<option value="" >Please Select</option>
				                  		@if(!empty($types) && count($types) > 0)
				                  			@foreach($types as $key => $type)
				                  				<option value="{{ base64_encode(base64_encode($type->id)) }}" @if($object->question_type == $type->slug ) selected @endif>{{ $type->title }}</option>
				                  			@endforeach
				                  		@endif
				                  	</select>
				                </div>
	              			</div>	
	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Category <span style="color: red">*</span></label>
				                  	<select class="form-control" name="category" >
				                  		<option value="" >Please Select</option>
				                  		@if(!empty($types) && count($category) > 0)
				                  			@foreach($category as $key => $type)
				                  				<option value="{{ $type->id }}"  @if($object->category_id == $type->id ) selected @endif>{{ $type->category_name }}</option>
				                  			@endforeach
				                  		@endif
				                  	</select>
				                </div>
	              			</div>
	                  		<div class="html_data">

	                  			<div class="col-md-12">
		                  			<label>Type your question</label>
		                  			<textarea type="text" class="form-control" name="question_text" rows="5">{{ $object->question_text }}</textarea><br>
		                  		</div>

	                  			@if($object->questionFormat->option == 'radio')
	                  				<div class="multiple_choice">

			              			<div class="options">
				              			<div class="col-md-11">
				              				Correct
				              				<div class="input-group">
						                        <span class="input-group-addon">
				              						<label>A</label><br>
						                          <input type="radio" @if( $object->correct_answer == 'a' ) checked @endif name="correct" value="a">
						                        </span>
						                    	<textarea type="text" name="option1"  class="form-control">{{ $object->option1 }}</textarea>
						                  	</div><br>
					                  	</div>
				                  	</div>
			              			
			              			<div class="options">
				              			<div class="col-md-11">
						                  	<div class="input-group">
						                        <span class="input-group-addon">
						                        	<label>B</label><br>
						                          <input type="radio" @if( $object->correct_answer == 'b' ) checked @endif name="correct" value="b">
						                        </span>
						                    	<textarea type="text" name="option2" class="form-control">{{ $object->option2 }}</textarea>
						                  	</div><br>
					                  	</div>
				                  	</div>
			              			
			              			<div class="options">
				              			<div class="col-md-11">
						                  	<div class="input-group">
						                        <span class="input-group-addon">
						                        	<label>C</label><br>
						                          <input type="radio" @if( $object->correct_answer == 'c' ) checked @endif name="correct" value="c">
						                        </span>
						                    	<textarea type="text" name="option3" class="form-control">{{ $object->option3 }}</textarea>
						                  	</div><br>
					                  	</div>
				                  	</div>
			              			
			              			<div class="options">
				              			<div class="col-md-11">
						                  	<div class="input-group">
						                        <span class="input-group-addon">
						                        	<label>D</label><br>
						                          <input type="radio" @if( $object->correct_answer == 'd' ) checked @endif name="correct" value="d">
						                        </span>
						                    	<textarea type="text" name="option4" class="form-control">{{ $object->option4 }}</textarea>
				                  			</div><br>
				              			</div>
			              			</div>

			              			@if(!empty($object->option5))
			              			<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>E</label><br>
							                      <input type="radio" @if( $object->correct_answer == 'e' ) checked @endif name="correct" value="e">
							                    </span>
							                	<textarea type="text" class="form-control" name="option5">{{ $object->option5 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleChoiceOption(this)"></i>
										</div>
									</div>
									@endif

									@if(!empty($object->option6))
									<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>F</label><br>
							                      <input type="radio" @if( $object->correct_answer == 'f' ) checked @endif name="correct" value="f">
							                    </span>
							                	<textarea type="text" class="form-control" name="option6">{{ $object->option6 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleChoiceOption(this)"></i>
										</div>
									</div>
									@endif

									@if(!empty($object->option7))
									<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>G</label><br>
							                      <input type="radio" @if( $object->correct_answer == 'g' ) checked @endif name="correct" value="g">
							                    </span>
							                	<textarea type="text" class="form-control" name="option7">{{ $object->option7 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleChoiceOption(this)"></i>
										</div>
									</div>
									@endif

									@if(!empty($object->option8))
									<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>H</label><br>
							                      <input type="radio" @if( $object->correct_answer == 'h' ) checked @endif name="correct" value="h">
							                    </span>
							                	<textarea type="text" class="form-control" name="option8">{{ $object->option8 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleChoiceOption(this)"></i>
										</div>
									</div>
									@endif

			              			<div class="col-md-11" >
			              				<a class="btn btn-info add_new_choice" onclick="return AddMultipleChoiceOption(this)" style="float: right;" >Add new</a>
			              			</div>
		              				</div>
		              			@endif

		              			@if($object->questionFormat->option == 'checkbox')

		              				@php 
		              					$correct_answers = explode(',', $object->correct_answer); 
		              				@endphp
		              				<div class="multiple_response">
			                  		
			              			<div class="options">
				              			<div class="col-md-11">
				              				Correct
				              				<div class="input-group">
						                        <span class="input-group-addon">
				              						<label>A</label><br>
						                          <input type="checkbox" name="correct[]" @if(in_array('a',$correct_answers)) checked @endif value="a">
						                        </span>
						                    	<textarea type="text" name="option1" class="form-control">{{ $object->option1 }}</textarea>
						                  	</div><br>
					                  	</div>
				                  	</div>
			              			
			              			<div class="options">
				              			<div class="col-md-11">
						                  	<div class="input-group">
						                        <span class="input-group-addon">
						                        	<label>B</label><br>
						                          <input type="checkbox" name="correct[]" @if(in_array('b',$correct_answers)) checked @endif value="b">
						                        </span>
						                    	<textarea type="text" name="option2" class="form-control">{{ $object->option2 }}</textarea>
						                  	</div><br>
					                  	</div>
				                  	</div>
			              			
			              			<div class="options">
				              			<div class="col-md-11">
						                  	<div class="input-group">
						                        <span class="input-group-addon">
						                        	<label>C</label><br>
						                          <input type="checkbox" name="correct[]" @if(in_array('c',$correct_answers)) checked @endif value="c">
						                        </span>
						                    	<textarea type="text" name="option3" class="form-control">{{ $object->option3 }}</textarea>
						                  	</div><br>
					                  	</div>
				                  	</div>
			              			
			              			<div class="options">
				              			<div class="col-md-11">
						                  	<div class="input-group">
						                        <span class="input-group-addon">
						                        	<label>D</label><br>
						                          <input type="checkbox" name="correct[]" @if(in_array('d',$correct_answers)) checked @endif value="d">
						                        </span>
						                    	<textarea type="text" name="option4" class="form-control">{{ $object->option4 }}</textarea>
				                  			</div><br>
				              			</div>
			              			</div>

			              			@if(!empty($object->option5))
			              			<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>E</label><br>
							                      <input type="radio" name="correct[]" @if(in_array('e',$correct_answers)) checked @endif  value="e">
							                    </span>
							                	<textarea type="text" class="form-control" name="option5">{{ $object->option5 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleResponseOption(this)"></i>
										</div>
									</div>
									@endif

									@if(!empty($object->option6))
									<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>F</label><br>
							                      <input type="radio" name="correct[]"  @if(in_array('f',$correct_answers)) checked @endif value="f">
							                    </span>
							                	<textarea type="text" class="form-control" name="option6">{{ $object->option6 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleResponseOption(this)"></i>
										</div>
									</div>
									@endif

									@if(!empty($object->option7))
									<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>G</label><br>
							                      <input type="radio" name="correct[]"  @if(in_array('g',$correct_answers)) checked @endif  value="g">
							                    </span>
							                	<textarea type="text" class="form-control" name="option7">{{ $object->option7 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleResponseOption(this)"></i>
										</div>
									</div>
									@endif

									@if(!empty($object->option8))
									<div class="options">
										<div class="col-md-11">
							              	<div class="input-group">
							                    <span class="input-group-addon">
							                    	<label>H</label><br>
							                      <input type="radio" name="correct[]"  @if(in_array('h',$correct_answers)) checked @endif  value="h">
							                    </span>
							                	<textarea type="text" class="form-control" name="option8">{{ $object->option8 }}</textarea>
							      			</div><br>
							  			</div>
										<div class="col-md-1">
											<i class="fa fa-trash" onclick="return removeMultipleResponseOption(this)"></i>
										</div>
									</div>
									@endif

			              			<div class="col-md-11" >
			              				<a class="btn btn-info add_new_response" onclick="return AddMultipleResponseOption(this)" style="float: right;" >Add new</a>
			              			</div>
		              				</div>
		              			@endif

		              			<div class="col-md-2">
		                  			<div class="form-group">
				                  		<label for="">Right Marks</label>
				                  		<input type="number" class="form-control" placeholder="0" value="{{ $object->right_marks }}" name="right_marks">
				                	</div>
		                  		</div>

	                  		</div>

	              		</div>
	              	</div>

	              	<div class="box-footer">
		                <button type="submit" id="submit_button" class="btn btn-primary">Submit</button>
            	  	</div>
	            </form>
	      </div>
	    </section>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/repository/create&edit.js') }}"></script>
@stop