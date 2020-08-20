@extends('website.app')
@section('content')
	<x-website.ui.breadcrumbs class="bg-accent">
		<div class="text-white page-breadcrumb d-flex align-items-end">
			<div class="page-breadcrumb-item">{{ trans('store.address.new') }}</div>
		</div>
	</x-website.ui.breadcrumbs>
    <main class="my-2">
        <div class="container">
            <h1 class="text-primary">{{ trans('store.address.new') }}</h1>

            @include('flash::notification')
            <form class="" action="" method="post">
        		{{ csrf_field() }}
        		<input type="hidden" name="previous" value="{{$previous}}">
        		<div class="row form-group">
        			<div class="col-12 col-sm-6">
        				<div class="row form-group">
        					<div class="col-12 col-sm-6">
        						<input class="form-control" type="text" name="street" value="{{ old('street') }}" placeholder="{{trans('store.address.fields.street')}}" required>
        					</div>
        					<div class="col-12 col-sm-6">
        						<input class="form-control" type="text" name="number" value="{{ old('number') }}" placeholder="{{trans('store.address.fields.number')}}" required>
        					</div>
        				</div>
        				<div class="row form-group">
        					<div class="col-12 col-sm-6">
        						<input class="form-control" type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="{{trans('store.address.fields.zip_code')}}" required>
        					</div>
        					<div class="col-12 col-sm-6">
        						<input class="form-control" type="text" name="city" value="{{ old('city') }}" placeholder="{{trans('store.address.fields.city')}}" required>
        					</div>
        				</div>
        				<div class="row form-group">
        					<div class="col-12 col-sm-6">
        						<input class="form-control" type="text" name="province" value="{{ old('province') }}" placeholder="{{trans('store.address.fields.province')}}" required>
        					</div>
        					<div class="col-12 col-sm-6">
        						<select class="form-control" name="country_id" required>
        							@foreach ($countries as $_country)
        								<option value="{{$_country->id}}" @if(old('country-id') == $_country->id) selected="true" @endif>{{$_country->name}}</option>
        							@endforeach
        						</select>
        					</div>
        				</div>
        				<input class="form-control" type="text" name="vat" value="{{ old('vat') }}" placeholder="{{trans('store.address.fields.vat')}}">
        			</div>
        			<div class="col-12 col-sm-6">
        				<input class="form-control form-group" type="text" name="phone" value="{{ old('phone') }}" placeholder="{{trans('store.address.fields.phone')}}">
        				<input class="form-control form-group" type="text" name="mobile" value="{{ old('mobile') }}" placeholder="{{trans('store.address.fields.mobile')}}">
        				<input class="form-control form-group" type="email" name="email" value="{{ (old('email'))? old('email') : auth()->guard()->user()->email}}" placeholder="{{trans('store.address.fields.email')}}">
        			</div>
        		</div>
        		<button type="submit" class="btn btn-primary">
        			{{trans('store.address.save')}}
        		</button>
            </form>
        </div>
    </main>

@endsection
