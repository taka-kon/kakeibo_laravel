
function popupImage() {
  var popup = document.getElementById('js-popup');
  if(!popup) return;

  var blackBg = document.getElementById('js-black-bg');

  var closeBtn = document.getElementById('js-close-btn');
  var closeBtn2 = document.getElementById('js-close-btn2');
  var showBtn = document.getElementById('js-show-popup');

  closePopUp(blackBg);
  closePopUp(closeBtn);
  closePopUp(closeBtn2);
  closePopUp(showBtn);
  function closePopUp(elem) {
    if(!elem) return;
    elem.addEventListener('click', function() {
      popup.classList.toggle('is-show');
    });
  }
}
popupImage();

//フェードアウト処理
function fadeOut(node, duration) {
  node.style.opacity = 1;

  var start = performance.now();
  
  requestAnimationFrame(function tick(timestamp) {
    var easing = (timestamp - start) / duration;
    node.style.opacity = Math.max(1 - easing, 0);
    if (easing < 1) {
      requestAnimationFrame(tick);
    } else {
      node.style.opacity = '';
      node.style.display = 'none';
    }
  });
}
//表示してから3秒後に実行
setTimeout("fadeOut(document.querySelector('#main-input__msg'), 800)", 2000);
setTimeout("fadeOut(document.querySelector('#main-index__msg'), 800)", 2000);



//マイページの今月出費の数値の表示の仕方
var price = document.getElementById("price");
// 出費額を格納
const max = parseInt(price.innerHTML);
// カウントの初期値（出費額-40）
count = parseInt(price.innerHTML)-160;
/*
max=41...count=2...2,3,4...41(40個)
max=40...count=1...1,2,3...40(40個)
max=39...count=0...0,1,2...39(40個)
max=38...count=-1...(×-1),0,1,2...38(39個)
max=37...count=-2...(×-2).(×-1),0,1,2...37(38個)
max=0...count=-39...(×-39),(×-38),...,(×-1),0(1個)
*/
// countupクロージャ countに1足しprice.innerHTMLに代入
countup=function(){
	count++;
	//この辺でif文で条件分岐する
	/*
		countが負数の時、price...は0にする
	*/ 
	if(count>=0){
		price.innerHTML=count;

	}
}

var id = setInterval(function(){
	countup();
	if(count>max-1){
		clearInterval(id);
	}
},1);



