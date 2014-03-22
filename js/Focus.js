/**
 * @classDescription  ç„¦ç‚¹å›¾æž„é€ å‡½æ•°
 * @type {Object}
 * @param {String | Array} éœ€åˆ‡æ¢æ˜¾ç¤ºçš„å…ƒç´  
 * @param {String | Array} æŽ§åˆ¶å™¨å…ƒç´  
 * @param {Object}  å‚æ•°é›†åˆï¼ˆåŒ…æ‹¬event,effect,scrollDir,scrollSpeed,scrollMode,timeout,index,callbackï¼‰
 */ 
function Focus(foc, ctr, opiton){
	this.setOption(opiton);	
	this.imgs = typeof foc == "string"?Kg.$C(foc):foc;
	this.ctrs = typeof ctr == "string"?Kg.$C(ctr):ctr;
	this.l = this.imgs.length;
	this.timer = null;

	if(this.option.effect === "fade" && this.ctrs){
		for(var i = 0; i < this.l; i++){
			Kg.addEvent(this.ctrs[i], this.option.event, Kg.bind(function(i){
				this.over(i);
			}, this, i));

			Kg.addEvent(this.ctrs[i], "mouseout", Kg.bind(function(){
				this.start();
			}, this));

			Kg.addEvent(this.ctrs[i], "mouseover", Kg.bind(function(){
				clearTimeout(this.timer);
			}, this));
		}
	}

	if(this.option.effect === "scroll"){
		this.father = this.imgs[0].parentNode;
		this.size = this.option.scrollDir === "Left"?this.imgs[0].offsetWidth:this.imgs[0].offsetHeight;
				
		if(this.option.scrollMode == 2){
			this.father.innerHTML += this.father.innerHTML;
			this.imgs = typeof foc == "string"?Kg.$C(foc):foc;
			this.l = this.imgs.length
		}

		for(var i = 0; i < this.l; i++){
			this.imgs[i].style.position = "absolute";
			this.imgs[i]["style"][this.option.scrollDir.toLowerCase()] = i * this.size + "px";
			this.ctrs[i] && Kg.addEvent(this.ctrs[i], this.option.event, Kg.bind(function(i){
				i = this.currentIndex > this.realLength - 1?(i + this.realLength):i;
				this.over(i);
			}, this, i));
		}
	}
	
	this.realLength = this.option.scrollMode == 2?this.l/2:this.l;
	this.currentIndex = this.option.index === "random"?
		parseInt(Math.random() * this.realLength):
		this.option.index;
	this.ctrs && (this.ctrs[this.currentIndex].className += " current");
	this.option.effect === "fade"?
		(this.imgs[this.currentIndex].style.display = "block"):
		(this.father["scroll"+this.option.scrollDir] = this.size * this.currentIndex);

	this.start();
};

Focus.prototype.setOption = function(option){
	this.option = {
		event: "click",		//åˆ‡æ¢äº‹ä»¶
		effect:"fade",		//åˆ‡æ¢æ¨¡å¼
		scrollDir: "Left",  //æ»šåŠ¨æ–¹å‘
		scrollSpeed: 0.1,  //æ»šåŠ¨é€Ÿåº¦
		scrollMode:1,	   //æ»šåŠ¨æ¨¡å¼ï¼Œ1ä»£è¡¨æ»šåŠ¨åˆ°å°½å¤´åŽå¾€åŽåˆ‡å›žï¼Œ2ä»£è¡¨æ— ç¼æ»šåŠ¨
		timeout:3000,	//åˆ‡æ¢æ—¶é—´
		index:0,		//currentIndex
		onstart: null,	//å¼€å§‹è¿è¡Œå‰æ‰§è¡Œçš„å‡½æ•°
		callback:null   //å›žè°ƒå‡½æ•°
	};

	Kg.extend(this.option, option || {}, true);
};

Focus.prototype.start = function(){
	this.timer = setTimeout(Kg.bind(this.change, this),this.option.timeout);
};

Focus.prototype.change = function(){
	if(this.option.effect === "fade"){
		var step = Kg.UA.Ie?3:1;
		var _this = this;
		var current = this.imgs[this.currentIndex];
		this.ctrs && (this.ctrs[this.currentIndex].className = this.ctrs[this.currentIndex].className.replace(/\s*current/,""));

		var next = (this.currentIndex === this.l - 1)?
			this.imgs[(this.currentIndex = 0)]:
			this.imgs[++this.currentIndex];
		this.ctrs && (this.ctrs[this.currentIndex].className += " current");

		current.style.zIndex = 100;
		next.style.cssText = "display:block; z-index:99";
		
		this.option.onstart && this.option.onstart(this);

		current.timer = Kg.fadeout(current, 1, step, function(){
			_this.reset();
			_this.start();
			_this.option.callback && _this.option.callback(this);
		});	
	}

	if(this.option.effect === "scroll"){
		var speed = Kg.UA.Ie?this.option.scrollSpeed:(this.option.scrollSpeed-0.04);
		if(this.option.scrollMode == 2){
			if(this.currentIndex == this.l -1){
				this.father["scroll" + this.option.scrollDir] = (this.realLength - 1)*this.size;
				this.currentIndex = this.realLength - 1;
			}
		}
		
		this.ctrs && (this.ctrs[this.currentIndex % this.realLength].className = this.ctrs[this.currentIndex % this.realLength].className.replace(/\s*current/,""));
		this.currentIndex === (this.l - 1)?(this.currentIndex = 0):++this.currentIndex;
		this.ctrs && (this.ctrs[this.currentIndex % this.realLength].className += " current");
		var start = this.father["scroll" + this.option.scrollDir];
		var end = this.currentIndex * this.size;
		var _this = this;
		this.option.onstart && this.option.onstart(this);
		this.timer = Kg.slide(this.father, "scroll" + this.option.scrollDir, start, end, speed, function(){
			clearInterval(_this.timer);
			_this.option.callback && _this.option.callback(_this);
			_this.start();
		});
	}
};

Focus.prototype.reset = function(index){
	var index = index || ((this.currentIndex === 0)?this.l - 1:this.currentIndex - 1);
	var resetEl = this.imgs[index];
	resetEl.style.cssText = "display:none; z-index:1";
	clearInterval(resetEl.timer);
	Kg.setOpacity(resetEl, 100);
};

Focus.prototype.over = function(i){
	clearTimeout(this.timer);
	
	if(this.option.effect === "fade"){
		var step = Kg.UA.Ie?3:1;
		var curIndex = this.currentIndex;
		var curEl = this.imgs[curIndex];
		var nextEl = this.imgs[i];
		var _this = this;
		curEl.style.zIndex = 1000;
		clearInterval(curEl.timer);
		clearInterval(nextEl.timer);
		Kg.setOpacity(curEl, 100);

		nextEl.style.cssText = "display:block; z-index:999";

		if(this.ctrs){
			this.ctrs[this.currentIndex].className = this.ctrs[this.currentIndex].className.replace(/\s*current/,"");
			this.ctrs[i].className += " current";
		}
		this.currentIndex = i;
		this.option.onstart && this.option.onstart(this);

		curEl.timer = Kg.fadeout(curEl, 1, step, function(){
			_this.reset(curIndex);
			_this.option.callback && _this.option.callback(this);
		});	
	}

	if(this.option.effect === "scroll"){
		var speed = Kg.UA.Ie?this.option.scrollSpeed:(this.option.scrollSpeed-0.04);
		if(this.option.scrollMode == 2){
			if(this.currentIndex == this.l -1 && i == 0){
				this.father["scroll" + this.option.scrollDir] = (this.realLength - 1)*this.size;
				i = this.realLength; 
			}
			if(this.currentIndex == 0 && i == this.l - 1){
				this.father["scroll" + this.option.scrollDir] = this.realLength*this.size;
				i = this.realLength - 1; 
			}
		}

		this.ctrs && (this.ctrs[this.currentIndex % this.realLength].className = this.ctrs[this.currentIndex % this.realLength].className.replace(/\s*current/,""));
		this.currentIndex = i;
		this.ctrs && (this.ctrs[this.currentIndex % this.realLength].className += " current");
		var start = this.father["scroll" + this.option.scrollDir];
		var end = this.currentIndex * this.size;
		var _this = this;
		this.option.onstart && this.option.onstart(this);
		this.timer = Kg.slide(this.father, "scroll" + this.option.scrollDir, start, end, speed, function(){
			clearInterval(_this.timer);
			_this.option.callback && _this.option.callback(_this);
			_this.start();
		});
	}
};

Focus.prototype.prev = function(){
	var index = (this.currentIndex === 0)?this.l - 1:this.currentIndex - 1;
	this.over(index);
	this.option.effect === "fade" && this.start();
};

Focus.prototype.next = function(){
	var index = (this.currentIndex === this.l - 1)?0:this.currentIndex + 1;
	this.over(index);
	this.option.effect === "fade" && this.start();
}