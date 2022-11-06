@extends('layouts.master')

@section('title', 'BMI')
@section('content')

<!--content-->
    <section class="index-content">
        <div class="container"> 
            
             <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}">{{ __('trans.home') }}</a></li>
                          <li class="breadcrumb-item"><a href="{{ url('/bmi-calculator')}}">BMI Calculator</a></li>
             </ol>
                <div class="post comptbody">
                <h1 class="text-center">{{ __('trans.bmi_calc') }}</h1>
                @if( $errors->has('msg') )
                    <h4 style=" text-align: center; color: red; ">{{$errors->first('msg')}}</h4>
                @endif
                @if( $errors->has('success') )
                    <h4 style=" text-align: center; color: green; ">{{$errors->first('success')}}</h4>
                @endif
    <form class="moreInfo"  method="post"  style="max-width:100%" onsubmit="BMICalc(); return false;">
                @csrf
                <div style="max-width:500px; margin:auto;text-align:center">
                <div class="row">
                <div class="col-md-9">
                <div class="col-md-4">
                    <label>{{ __('trans.height') }}</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="height" required placeholder="{{ __('trans.height') }}" />
                </div>
                  </div>
                  <div class="col-md-3">
                    <select id="height_unit">
                        <option value="1">Inche</option>
                        <option value="12">Feet</option>
                        <option value="39.3701">Meter</option>
                        <option value="0.39370078740157477">centimeter</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                <div class="col-md-9">
                <div class="col-md-4">
                    <label>{{ __('trans.weight') }}</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="weight"  required placeholder="{{ __('trans.weight') }}" />
                </div>
                  </div>
                  <div class="col-md-3">
                    <select id="weight_unit">
                        <option value="1">Pound</option>
                        <option value="2.205">Kg</option>
                    </select>
                  </div>
                </div>
<br/>
                 <button type="submit" class="btn btn-setaat mauto">{{ __('trans.calc') }}</button>
                <br/>
            <div id="output"></div>
                <br/>
                </div>
                
                </form>
           
            </div>
        </div>
    </section>
    
@endsection
@section('cScripts')
<script>
    function BMICalc(){

        var height = $('#height').val();
        var weight = $('#weight').val();

        var hunit = $('#height_unit option:selected').attr('value');
        var wunit = $('#weight_unit option:selected').attr('value');

        height = height * hunit; // inche
        weight = weight * wunit; // pound

        BMI = 703 * ( weight / ( height * height ) );
        BMI = Math.round(BMI * 100) / 100;
        $('#output').html("<b>"+BMI+" Kg/m²</b>");
        return false;
    }
</script>
@endsection