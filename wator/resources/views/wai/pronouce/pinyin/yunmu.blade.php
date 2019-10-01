
<div class="col-12 bg-secondary" id="vue-ui-pinyin-table">
  <div id="carouselPinyinIndicators" class="carousel" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
      <div class="row justify-content-center">
        <div class="col-8">
          <div v-bind:class="'carousel-item ' + pinyinGroup.show" v-for="pinyinGroup in pinyinTable" >
            <div class="row justify-content-center mt-5" v-for="pinyinRow in pinyinGroup.group">
              <div class="col" v-for="pinyin in pinyinRow">
                <a class="btn btn-success btn-lg" v-bind:href="'/wai/pronounce/zhpinyin/yunmu/' + pinyin"><h1>@{{pinyin}}</h1></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselPinyinIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next ml-5" href="#carouselPinyinIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<script>
  const onLoadedPinYinTable = () => {
    const pinyin = [
      {
        group:[
          ['a','o','e'],
          ['i','u','ü'],
          ['ê','-i','-i'],
          ['er'],
        ],
        show:''
      },
      {
        group:[
          
          ['ai','ei','ao','ou'],
          ['ia','ie','ua','uo','üe'],
          ['iao','iou','uai','uei'],
        ],
        show:''
      },
      {
        group:[
          ['an','ian','uan','üan','en'],
          ['in','uen','ün','ang','iang'],
          ['uang','eng','ing','ueng','ong'],
          ['iong'],
        ],
        show:''
      },

    ];
    const training = '{{ $yinjie }}';
    for(let groupPinyin of pinyin) {
      console.log('onLoadedPinYinTable::groupPinyin=<',groupPinyin,'>');
      for(let pinyinRow of groupPinyin.group) {
        console.log('onLoadedPinYinTable::pinyinRow=<',pinyinRow,'>');
        if(pinyinRow.indexOf(training) > -1) {
          groupPinyin.show = 'active';
        }
      }
    }
    const app = new Vue({
      el: '#vue-ui-pinyin-table',
      data: {
        pinyinTable: pinyin
      }
    });
    app.$forceUpdate();    
  }
  document.addEventListener('DOMContentLoaded', onLoadedPinYinTable);
</script>
