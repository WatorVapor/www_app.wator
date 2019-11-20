
<div class="col-12 bg-secondary" id="vue-ui-pinyin-table">
  <div id="carouselPinyinIndicators" class="carousel" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
      <div class="row justify-content-center">
        <div class="col-8">
          <div v-bind:class="'carousel-item ' + pinyinGroup.show" v-for="pinyinGroup in pinyinTable" >
            <div class="row justify-content-center mt-5" v-for="pinyinRow in pinyinGroup.group">
              <div class="col" v-for="pinyin in pinyinRow">
                <a class="btn btn-success btn-lg" v-bind:href="'/wai/pronounce/zhpinyin/yinjie/' + pinyin"><h1>@{{pinyin}}</h1></a>
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
          ['a','ā','á','ǎ','à'],
          ['ai','āi','ái','ǎi','ài'],
        ],
        show:''
      },
      {
        group:[
          ['an','ān','án','ǎn','àn'],
          ['ang','āng','áng','ǎng','àng'],
          ['ao','āo','áo','ǎo','ào'],
        ],
        show:''
      },
      {
        group:[
          ['ba','bā','bá','bǎ','bà'],
          ['bai','bāi','bái','bǎi','bài'],
          ['ban','bān','bán','bǎn','bàn'],
          ['bang','bāng','báng','bǎng','bàng'],
          ['bao','bāo','báo','bǎo','bào'],
        ],
        show:''
      },
      {
        group:[
          ['bei','bēi','béi','běi','bèi'],
          ['ben','bēn','bén','běn','bèn'],
          ['beng','bēng','béng','běng','bèng'],
        ],
        show:''
      },
      {
        group:[
          ['bi','bī','bí','bǐ','bì'],
          ['bian','biān','bián','biǎn','biàn'],
          ['biao','biāo','biáo','biǎo','biào'],
          ['bie','biē','bié','biě','biè'],
          ['bin','bīn','bín','bǐn','bìn'],
          ['bing','bīng','bíng','bǐng','bìng'],
        ],
        show:''
      },
      {
        group:[
          ['bo','bō','bó','bǒ','bò'],
          ['bu','bū','bú','bǔ','bù'],
        ],
        show:''
      },
      {
        group:[
          ['ca','cā','cá','cǎ','cà'],
          ['cai','cāi','cái','cǎi','cài'],
        ],
        show:''
      },
      {
        group:[
          ['can','cān','cán','cǎn','càn'],
          ['cang','cāng','cáng','cǎng','càng'],
          ['cao','cāo','cáo','cǎo','cào'],
        ],
        show:''
      },

      {
        group:[
          ['ce','cē','cé','cě','cè'],
          ['cen','cēn','cén','cěn','cèn'],
          ['ceng','cēng','céng','cěng','cèng'],
        ],
        show:''
      },
      {
        group:[
          ['cha','chā','chá','chǎ','chà'],
          ['chai','chāi','chái','chǎi','chài'],
        ],
        show:''
      },
      {
        group:[
          ['chan','chān','chán','chǎn','chàn'],
          ['chang','chāng','cháng','chǎng','chàng'],
          ['chao','chāo','cháo','chǎo','chào'],
        ],
        show:''
      },
      
      {
        group:[
          ['che','chē','ché','chě','chè'],
          ['chen','chēn','chén','chěn','chèn'],
          ['cheng','chēng','chéng','chěng','chèng'],
        ],
        show:''
      },
      {
        group:[
          ['chi','chī','chí','chǐ','chì'],
          ['chong','chōng','chóng','chǒng','chòng'],
          ['chou','chōu','chóu','chǒu','chòu'],          
          ['chu','chū','chú','chǔ','chù'],
          ['chuai','chuāi','chuái','chuǎi','chuài'],
        ],
        show:''
      },
      {
        group:[
          ['chuan','chuān','chuán','chuǎn','chuàn'],
          ['chuang','chuāng','chuáng','chuǎng','chuàng'],
        ],
        show:''
      },

      {
        group:[
          ['chui','chuī','chuí','chuǐ','chuì'],
          ['chun','chūn','chún','chǔn','chùn'],
          ['chuo','chuō','chuó','chuǒ','chuò'],
        ],
        show:''
      },
      {
        group:[
          ['ci','cī','cí','cǐ','cì'],
          ['cong','cōng','cóng','cǒng','còng'],
          ['cu','cū','cú','cǔ','cù'],
        ],
        show:''
      },
      
      {
        group:[
          ['cuan','cuān','cuán','cuǎn','cuàn'],
          ['cui','cuī','cuí','cuǐ','cuì'],
          ['cun','cūn','cún','cǔn','cùn'],
          ['cuo','cuō','cuó','cuǒ','cuò'],
        ],
        show:''
      },

      {
        group:[
          ['da','dā','dá','dǎ','dà'],
          ['dai','dāi','dái','dǎi','dài'],
        ],
        show:''
      },
      {
        group:[
          ['dan','dān','dán','dǎn','dàn'],
          ['dang','dāng','dáng','dǎng','dàng'],
          ['dao','dāo','dáo','dǎo','dào'],
        ],
        show:''
      },
      
      {
        group:[
          ['de','dē','dé','dě','dè'],
          ['dei','dēi','déi','děi','dèi'],
          ['deng','dēng','déng','děng','dèng'],
          ['er','ēr','ér','ěr','èr'],
        ],
        show:''
      },

      
      {
        group:[
          ['e','ē','é','ě','è'],
          ['ei','ēi','éi','ěi','èi'],
          ['en','ēn','én','ěn','èn'],
          ['er','ēr','ér','ěr','èr'],
        ],
        show:''
      },

      {
        group:[
          ['o','ō','ó','ǒ','ò'],
          ['ou','ōu','óu','ǒu','òu'],
        ],
        show:''
      },


      {
        group:[
          ['u','ū','ú','ǔ','ù'],
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
