@extends('wator.app')


@section('appnavbar')
  @include('wai.navbar')
@endsection

@section('content')

<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <div class="panel panel-default">
      <div class="panel-body">
        <form class="form-horizontal" method="POST" action="#" accept-charset="utf-8">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="col-lg-12">
              <textarea class="form-control inputfield text" cols="50" rows ="5" placeholder="Enter sentence" name="sentence">{{ $text }}</textarea>
            </div>
          </div>
          <div class="form-group">        
            <div class="col-lg-offset-4 col-lg-2">
              <button type="submit" value="cn" name="lang" class="btn btn-block btn-primary"> {{ trans('participle.chinese') }} </button>
            </div>
            <div class="col-lg-2">
              <button type="submit" value="jp" name="lang" class="btn btn-block btn-success"> {{ trans('participle.japanese') }} </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <div class="panel panel-default">
      <div class="panel-body">
        <pre style="white-space: pre-wrap ;">{{ $result }}</pre>
      </div>
    </div>
  </div>
</div>



@endsection
