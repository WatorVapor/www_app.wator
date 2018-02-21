
let dataAudio = [
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5,
  0.0,0.1,1.0,-1.0,-0.12,0.12,0.11,0.23,-0.5,0.5
];

const ppd = 1.0;
const aspect = 0.2;
function showWaveChart(data) {
  //console.log('showWaveChart::data=<',data,'>');
  let width = data.length * ppd;
  let height = width * aspect;
  console.log('showWaveChart::width=<',width,'>');
  console.log('showWaveChart::height=<',height,'>');
  
  let chart ='';
  chart += '<?xml version="1.0" standalone="no"?>\n'
  chart += '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" \n'
  chart += '"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\n';


  chart += '<svg width="' + width + 'px" height="' + height + 'px">\n';
  
 // chart += '<g stroke="red" >\n'
  
  
  let maxY = Math.max.apply(null, data);
  let minY = Math.min.apply(null, data);
  let heightY = maxY - minY;
  console.log('showWaveChart::maxY=<',maxY,'>');
  console.log('showWaveChart::minY=<',minY,'>');
  console.log('showWaveChart::heightY=<',heightY,'>');
  
  
  let pointsList = '"\n';
  for(let i = 0 ;i < data.length;i++) {
    let pointX = i* ppd;
    let pointY = (height * (data[i] - minY))/heightY;
    pointsList += pointX + ',' + pointY + ' ';
    if(i % 8 === 0) {
      pointsList += '\n';
    }
  }
  pointsList += '"\n';
  chart += '<polyline fill="none" stroke="blue" stroke-width="10" points=';
  chart += pointsList;
  chart += '/>\n';
  chart += '</svg>\n';
  console.log('showWaveChart::chart=<',chart,'>');
}

showWaveChart(dataAudio);

