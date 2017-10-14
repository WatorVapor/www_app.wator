@extends('wator.app')
@section('appnavbar')
  @include('story.navbar')
@endsection

@section('content')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
      <a href="/img/story/ai.story.{{ $animate }}.jpg" >
        <img height="120" src="/wator/images/story/ai.story.{{ $animate }}.jpg">
      <a>
   </div>
</div>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <pre class="bg-success text-danger" >
      {{trans('home.summary')}}
    </pre>
  </div>
</div>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="table-col"><a href="/story/home/top"> |<< </a></th>
          <th class="table-col"><a href="/story/home/prev"> < </a></th>
          <th class="table-col"></th>
          <th class="table-col"><a href="/story/home/next"> > </a></th>
          <th class="table-col"><a href="/story/home/last"> >>| </a></th>
        </tr>
      </thead>
      <tbody>
        <?php $counter=0; $pairt_tr = true;?>
        @foreach($chapters as $chapter => $title)
          @if ( $counter % 5 === 0)
            <?php $pairt_tr = true;?>
            <tr>
          @endif
          <td class="table-col"><a href="/story/slip/{{ $chapter }}">{{ $chapter }}.{{ $title }}</a></td>
          @if ( $counter % 5 === 4)
            <?php $pairt_tr = false;?>
            </tr>
          @endif
          <?php $counter++; ?>
        @endforeach
        @if ( $pairt_tr)
          </tr>
        @endif
      </tbody>
      <tfoot>
        <tr>
          <th class="table-col"><a href="/story/home/top"> |<< </a></th>
          <th class="table-col"><a href="/story/home/prev"> < </a></th>
          <th class="table-col"></th>
          <th class="table-col"><a href="/story/home/next"> > </a></th>
          <th class="table-col"><a href="/story/home/last"> >>| </a></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endsection
