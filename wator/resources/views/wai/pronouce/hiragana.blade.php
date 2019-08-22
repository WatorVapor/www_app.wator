
<div class="col-12 bg-secondary" id="vue-ui-hiragana-table">
  <div id="carouselHiraganaIndicators" class="carousel" data-ride="carousel">
    <div class="carousel-inner">
      <div class="row justify-content-center">
        <div class="col-8">
          <div v-bind:class="'carousel-item ' + hiraGroup.show" v-for="hiraGroup in hiraganaTable" >
            <div class="row justify-content-center mt-5" v-for="hiraRow in hiraGroup.group">
              <div class="col" v-for="hira in hiraRow">
                <a class="btn btn-success btn-lg" v-bind:href="'/wai/pronounce/ja50on/' + hira"><h1>@{{hira}}</h1></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselHiraganaIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next ml-5" href="#carouselHiraganaIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<script>
  const onLoadedHiraganaTable = () => {
    const hiragana = [
      {
        group:[
          ['あ','え','う','え','お'],
          ['か','き','く','け','こ'],
          ['が','ぎ','ぐ','げ','ご'],
        ],
        show:''
      },
      {
        group:[
          ['さ','し','す','せ','そ'],
          ['ざ','じ','ず','ぜ','ぞ'],
          ['た','ち','つ','て','と'],
        ],
        show:''
      },
      {
        group:[
          ['だ','ぢ','づ','で','ど'],
          ['な','に','ぬ','ね','の'],
          ['は','ひ','ふ','へ','ほ'],
        ],
        show:''
      },
      {
        group:[
          ['ば','び','ぶ','べ','ぼ'],
          ['ぱ','ぴ','ぷ','ぺ','ぽ'],
          ['ま','み','む','め','も'],
        ],
        show:''
      },
      {
        group:[
          ['や','','ゆ','','よ'],
          ['ら','り','る','れ','ろ'],
          ['わ','を','ん','',''],
        ],
        show:''
      },
      {
        group:[
          ['きゃ','きゅ','きょ'],
          ['ぎゃ','ぎゅ','ぎょ'],
          ['しゃ','しゅ','しょ'],
        ],
        show:''
      },
      {
        group:[
          ['じゃ','じゅ','きょ'],
          ['ちゃ','ちゅ','ちょ'],
          ['ぢゃ','ぢゅ','ぢょ'],
        ],
        show:''
      },
      {
        group:[
          ['にゃ','にゅ','にょ'],
          ['みゃ','みゅ','みょ'],
          ['りゃ','りゅ','りょ'],
        ],
        show:''
      },
      {
        group:[
          ['ひゃ','ひゅ','ひょ'],
          ['びゃ','びゅ','びょ'],
          ['ぴゃ','ぴゅ','ぴょ'],
        ],
        show:''
      },
    ];
    const training = '{{ $yinjie }}';
    for(let groupHira of hiragana) {
      console.log('onLoadedHiraganaTable::groupHira=<',groupHira,'>');
      for(let hiraRow of groupHira.group) {
        console.log('onLoadedHiraganaTable::hiraRow=<',hiraRow,'>');
        if(hiraRow.indexOf(training) > -1) {
          groupHira.show = 'active';
        }
      }
    }
    const app = new Vue({
      el: '#vue-ui-hiragana-table',
      data: {
        hiraganaTable: hiragana
      }
    });
    app.$forceUpdate();    
  }
  document.addEventListener('DOMContentLoaded', onLoadedHiraganaTable);
</script>
