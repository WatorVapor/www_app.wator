@extends('wator.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">
      <h1> {{ trans('about_text.title') }} </h1>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-10 col-lg-offset-1">
      <h4> {{ trans('about_text.stage1') }} </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2 bg-warning">
      <code>蜗鸢</code>是在沼泽地群居和游牧的<code>鸟类</code>。
      在干旱期间要离开<code>自己的</code>巢区去寻找适合<code>自己的</code>生活方式和<code>栖息地</code>的水产品产区。
      有时在<code>栖息地</code>和觅食地来往要飞行相当大的距离。
      这种猛禽在繁殖季节非常活跃，由众多<code>鸟类</code><code>在此</code>期间<code>进行</code>空中杂技表演。
      雄性会<code>进行</code>短暂飙升，并在空中急速盘旋，缓慢拍击翅膀。<code>在此</code>之后，
      会邀请雌性合作伙伴，共同构建巢和提供的食物。
      ・・・
      <code>蜗鸢</code>因为是游牧<code>鸟类</code>，所以伴侣在繁殖期间结成联盟，但夫妻关系并不巩固。在佛罗里达州产卵期长达5个月，所以常修建三个或四个窝，如果伴侣关系破裂，卵还没有孵化，就必须寻求一个新的合作伙伴。
      
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2 bg-warning">
      <small>http://baike.baidu.com/item/蜗鸢<small>
    </div>
  </div>
  <hr/>
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2">
      <table class="table table-striped">
        <thead><tr><th> {{ trans('about_text.rank_word') }} </th><th>{{ trans('about_text.rank_times') }}</th></tr></thead>
        <tbody>
          <tr><td>鸟类</td><td>3</td></tr>
          <tr><td>--以下捨て--</td><td>----</td></tr>
          <tr><td>自己的</td><td>2</td></tr>
          <tr><td>栖息地</td><td>2</td></tr>
          <tr><td>在此</td><td>2</td></tr>
          <tr><td>进行</td><td>2</td></tr>
          <tr><td>蜗鸢</td><td>1</td></tr>
          <tr><td>蜗鸢是</td><td>1</td></tr>
          <tr><td>鸢是</td><td>1</td></tr>
          <tr><td>...</td><td>1</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
