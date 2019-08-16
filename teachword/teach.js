const redis = require("redis");
const redisOption = {
  port:6379,
  host:'127.0.0.1'
};
const SUB_CHANNEL = 'wai.teach.word.from.web'
const sub = redis.createClient(redisOption);
sub.on('message', (channel, message) => {
  console.log('sub::channel=<',channel,'>');
  console.log('sub::message=<',message,'>');
  let jsonMsg = JSON.parse(message);
  if(jsonMsg) {
    postWaiSNS(jsonMsg);
  }
});

sub.on('ready', (evt)=> {
  console.log('sub::ready evt=<',evt,'>');
});

sub.on("subscribe", (channel, count) => {
  console.log('sub::subscribe channel=<',channel,'>');
  console.log('sub::subscribe count=<',count,'>');
});

sub.subscribe(SUB_CHANNEL);

const WebSocket = require('ws');

const wss = new WebSocket.Server({
   port: 20080
});

wss.on('connection', (ws) =>{
  //console.log('wss::connection ws=<',ws,'>');
  ws.on('message', (data)=> {
    onWSSData(data,ws);
  });
});

onWSSData = (data,ws) => {
  //console.log('onWSSData data=<',data,'>');
  try {
    const msgJson = JSON.parse(data);
    if(msgJson && msgJson.request && msgJson.teach && msgJson.teach === 'word') {
      if(msgJson.stage && msgJson.stage === 'yesno') {
        onRequestTeachWordYesNo(msgJson,ws);
      }
    }
    if(msgJson && msgJson.response && msgJson.teach && msgJson.teach === 'word') {
      if(msgJson.stage && msgJson.stage === 'yesno') {
        onResponseTeachWordYesNo(msgJson,ws);
      }
    }
  } catch(e) {
    console.log('onWSSData e=<',e,'>');
  }
}

const fs = require('fs');
let cnPhraseContent = fs.readFileSync('/watorvapor/ldfs/ljson/wai/phrase/stage1/wai.stage1.phrase.cn.json', 'utf8');
console.log(':: cnPhraseContent.length=<',cnPhraseContent.length,'>');
const cnPhrase = JSON.parse(cnPhraseContent);
const cnPhraseKeys = Object.keys(cnPhrase);


const LevelDFS = require('./LevelDFS.js');
const cnPhraseCusorPath = '/watorvapor/ldfs/ljson/wai/phrase/stage1/wai.cursor.phrase.cn';
const cnCusorDB = new LevelDFS(cnPhraseCusorPath);


const cnPhraseCursor = {}

const onRequestTeachWordYesNo = (msgJson,ws) => {
  console.log('onRequestTeachWordYesNo:: msgJson=<',msgJson,'>');
  const cusorStr = cnCusorDB.getSync(msgJson.id);
  if(cusorStr) {
    cnPhraseCursor[msgJson.id] = JSON.parse(cusorStr);
  } else {
    cnPhraseCursor[msgJson.id] = {cursor:0};
  }
  const res = {teach:'word',stage:'yesno',words:[]};
  for(let i = 0;i < 8;i++) {
    const word = onRequestTeachWordOne(msgJson.id);
    if(word.word.length > 1) {
      res.words.push(word);
    }
  }
  console.log('onRequestTeachWordYesNo:: res=<',res,'>');
  ws.send(JSON.stringify(res));
  cnCusorDB.putSync(msgJson.id,JSON.stringify(cnPhraseCursor[msgJson.id],undefined,2));
}

const onRequestTeachWordOne =(id) => {
  const index = cnPhraseCursor[id].cursor;
  console.log('onRequestTeachWordOne:: index=<',index,'>');
  const indexWord = cnPhraseKeys[index];
  console.log('onRequestTeachWordOne:: indexWord=<',indexWord,'>');
  cnPhraseCursor[id].cursor++;
  cnPhraseCursor[id].cursor %= cnPhraseKeys.length;
  const rank = cnPhrase[indexWord];
  console.log('onRequestTeachWordOne:: rank=<',rank,'>');
  return {word:indexWord,rank:rank}
}


const humanJudegePath = '/watorvapor/ldfs/ljson/wai/phrase/stage1/wai.human.judege.ng.phrase.cn'
const humanJudegeDB = new LevelDFS(humanJudegePath);

const onResponseTeachWordYesNo =(msgJson,ws) => {
  console.log('onResponseTeachWordYesNo:: msgJson=<',msgJson,'>');
  const humanJudgeStr = humanJudegeDB.getSync(msgJson.word);
  let humanJudgeJson = {}
  if(humanJudgeStr) {
    humanJudgeJson = JSON.parse(humanJudgeStr);
    //humanJudgeJson = Object.assign({}, oldJson);
    humanJudgeJson.id.push(msgJson.id);
  } else {
    humanJudgeJson = msgJson;
  }
  humanJudegeDB.putSync(msgJson.word,JSON.stringify(humanJudgeJson,undefined,2));
}
