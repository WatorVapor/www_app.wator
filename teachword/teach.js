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
    if(msgJson && msgJson.teach && msgJson.teach === 'word') {
      if(msgJson.stage && msgJson.stage === 'yesno') {
        onRequestTeachWordYesNo(msgJson,ws);
      }
    }
  } catch(e) {
    console.log('onWSSData e=<',e,'>');
  }
}

const fs = require('fs');
let cnPhraseContent = fs.readFileSync('./wai.phrase.cn.json', 'utf8');
console.log(':: cnPhraseContent.length=<',cnPhraseContent.length,'>');
const cnPhrase = JSON.parse(cnPhraseContent);
const cnPhraseKeys = Object.keys(cnPhrase);

let cnPhraseCursor = {}
try {
  let cnPhraseCursorContent = fs.readFileSync('./wai.phrase.cn.cursor.json', 'utf8');
  console.log(':: cnPhraseCursorContent.length=<',cnPhraseCursorContent.length,'>');
  cnPhraseCursor = JSON.parse(cnPhraseCursorContent);
} catch (e) {
  
}
console.log(':: cnPhraseCursor=<',cnPhraseCursor,'>');

const onRequestTeachWordYesNo = (msgJson,ws) => {
  console.log('onRequestTeachWordYesNo:: msgJson=<',msgJson,'>');
  const res = {teach:'word',stage:'yesno',words:[]};
  for(let i = 0;i < 9;i++) {
    const word = onRequestTeachWordOne(msgJson.id);
    res.words.push(word);
  }
  console.log('onRequestTeachWordYesNo:: res=<',res,'>');
  ws.send(JSON.stringify(res));
}
const onRequestTeachWordOne =(id) => {
  if(!cnPhraseCursor[id]) {
    cnPhraseCursor[id] = {cursor:0};
  }
  const index = cnPhraseCursor[id].cursor;
  console.log('onRequestTeachWordYesNo:: index=<',index,'>');
  const indexWord = cnPhraseKeys[index];
  console.log('onRequestTeachWordYesNo:: indexWord=<',indexWord,'>');
  cnPhraseCursor[id].cursor++;
  cnPhraseCursor[id].cursor %= cnPhraseKeys.length;
  const rank = cnPhrase[indexWord];
  console.log('onRequestTeachWordYesNo:: rank=<',rank,'>');
  return {word:indexWord,rank:rank}
}