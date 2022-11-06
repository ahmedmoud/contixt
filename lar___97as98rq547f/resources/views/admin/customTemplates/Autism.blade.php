@extends('admin.master')
@section('content')
@php $isEdit = false; @endphp
<style> input{ text-align: left; direction: ltr;} </style>
<form action="{{ url('/admin/customTemplates/Autism') }}" method="POST" >
    @csrf
<div class="card">
<div class="card-body">
        <div class="form-group" style="text-align: left">
                <label for="tinymce">First 5</label>
                <div class="input-group mb-3">
                    <input  id="tinymce"  class="form-control" name="firstFive" value="{{  $value->firstFive  }}" />
                </div> 
            </div>   
        </div>
    </div>
<div class="card">
<div class="card-body">
@foreach ( [ 'first','second','third' ] as $n=> $p )
<div class="form-group" style="text-align: left">
        <label for="tinymce"> {{ $p }} </label>
        <div class="input-group mb-3">
        <div class="col-md-8">
            <input  class="form-control" rows="5" name="secondBlock[{{ $n }}][ids]" value="{{ $value->secondBlock[$n]->ids }}"  placeholder="IDs"/>
        </div>
        <div class="col-md-4">
                <input  class="form-control" rows="5" name="secondBlock[{{ $n }}][title]" value="{{  $value->secondBlock[$n]->title   }}" placeholder="title" />
            </div>
        </div>
    </div>   
@endforeach
        
        </div>
</div>
    


<div class="card">
<div class="card-body">
                <div class="form-group" style="text-align: left">
                        <label for="tinymce">Last Six </label>
                        <div class="input-group mb-3">
                        
                        <div class="col-md-12">
                            <input  class="form-control" rows="5" name="sixthSection" placeholder="IDs" value="{{ $value->sixthSection  }}" />
                        </div>
        
        
                        </div>
                    </div>  
        
        </div>
                        </div>
<input type="submit" value="Save" />
                    </form>

@endsection