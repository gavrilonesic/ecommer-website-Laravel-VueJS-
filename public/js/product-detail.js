//  $('.slider-for').slick({
//   slidesToShow: 1,
//   slidesToScroll: 1,
//   arrows: false,
//   fade: true,
//   asNavFor: '.slider-nav',
//   initialSlide:1,
// });
// $('.slider-nav').slick({
//   slidesToShow: 4,
//   slidesToScroll: 1,
//   asNavFor: '.slider-for',
//   dots: false,
//   centerMode: false,
//   focusOnSelect: true,
//   infinite: false,
// });
// $('.slider-nav').slick('setPosition');
// slideIndex = 10;
// $('.js-add-slide').on('click', function() {
//   slideIndex++;
//   // alert(slideIndex);
//   	html = '<div class="default-img" class="item 1"  data-js-hidesample >'
//     html += '<img src="http://placehold.it/150x75&text=100" alt="" />'
// 	html += '</div>';

//     html1 = '<img src="http://placehold.it/150x75&text=100" alt="" />';

//   $('.slider-nav').slick('slickAdd',html);
//   $('.slider-for').slick('slickAdd',html1);
//   $('.slider-for').slick('slickGoTo', slideIndex - 1);
//   $('.slider-nav').slick('slickGoTo', slideIndex - 1);
// });

// $('.js-remove-slide').on('click', function() {
// 	$('#default-img').attr('src','http://placehold.it/150x75&text=100')
// 	$('#default-img-thumb').attr('src','http://placehold.it/150x75&text=100')
// 	$('.default-img').toggle()
// 	// alert(slideIndex);
//   // $('.slider-nav').slick('slickRemove',(slideIndex-1));
//   // $('.slider-for').slick('slickRemove',(slideIndex-1));
//   // if (slideIndex !== 0){
//   //   slideIndex--;
//   // }
// });
// $(function(){
// 	var slider = $('#slider');
// 	var sliderWrap = $('#slider ul');
// 	var sliderImg = $('#slider ul li');
// 	var prevBtm = $('#sliderPrev');
// 	var nextBtm = $('#sliderNext');
// 	var length = sliderImg.length;
// 	var width = sliderImg.width();
// 	var thumbWidth = width/length;

// 	sliderWrap.width(width*(length+2));

// 	//Set up
// 	slider.after('<div id="' + 'pager' + '"></div>');
// 	var dataVal = 1;
// 	var second;
// 	sliderImg.each(
// 		function(){
// 			$(this).attr('data-img',dataVal);
// 			var display = $('img', this).attr('data-display')
// 			if($('img', this).attr('data-video')){
// 				$('#pager').append('<a data-img="' + dataVal + '"><div class="videothumb"><img class="video" data-video=' + $('img', this).attr('data-video') + ' data-toggle="modal" data-target="#videoModal" src=' + $('img', this).attr('src') + ' width=' + thumbWidth + '></div></a>');
// 			}else{
// 				if(display && display=='none')
// 				{
// 					second='y';
// 					$('#pager').append('<a data-img="' + dataVal + '" class="default-img-thumb" style="display:none"><img src=' + $('img', this).attr('src') + ' width=' + thumbWidth + '></a>');
// 				}else{
// 					$('#pager').append('<a data-img="' + dataVal + '"><img src=' + $('img', this).attr('src') + ' width=' + thumbWidth + '></a>');
// 				}
// 			}
// 		dataVal++;
// 	});

// 	//Copy 2 images and put them in the front and at the end
// 	$('#slider ul li:first-child').clone().appendTo('#slider ul');
// 	$('#slider ul li:nth-child(' + length + ')').clone().prependTo('#slider ul');

// 	sliderWrap.css('margin-left', - width);
// 	if(second && second=='y'){
// 		$('#slider ul li:nth-child(3)').addClass('active');
// 	}else{
// 		$('#slider ul li:nth-child(2)').addClass('active');
// 	}

// 	var imgPos = pagerPos = $('#slider ul li.active').attr('data-img');
// 	if(!pagerPos){
// 		 imgPos = pagerPos = 0;
// 	}
// 	$('#pager a:nth-child(' +pagerPos+ ')').addClass('active');


// 	//Click on Pager
// 	$('#pager a').on('click', function() {
// 		pagerPos = parseInt($(this).attr('data-img'));
// 		$('#pager a.active').removeClass('active');
// 		$(this).addClass('active');
// 		// alert(imgPos);
// 		// alert(pagerPos);
// 		if (pagerPos > imgPos) {
// 			var movePx = width * (pagerPos - imgPos);
// 			moveNext(movePx);
// 		}

// 		if (pagerPos < imgPos) {
// 			var movePx = width * (imgPos - pagerPos);
// 			movePrev(movePx);
// 		}
// 		return false;
// 	});

// 	//Click on Buttons
// 	nextBtm.on('click', function(){
// 		moveNext(width);
// 		return false;
// 	});

// 	prevBtm.on('click', function(){
// 		movePrev(width);
// 		return false;
// 	});

// 	//Function for pager active motion
// 	function pagerActive() {
// 		pagerPos = imgPos;
// 		$('#pager a.active').removeClass('active');
// 		$('#pager a[data-img="' + pagerPos + '"]').addClass('active');
// 	}

// 	//Function for moveNext Button
// 	function moveNext(moveWidth) {
// 		sliderWrap.animate({
//     		'margin-left': '-=' + moveWidth
//   			}, 500, function() {
//   				if (imgPos==length) {
//   					imgPos=1;
//   					sliderWrap.css('margin-left', - width);
//   				}
//   				else if (pagerPos > imgPos) {
//   					imgPos = pagerPos;
//   				}
//   				else {
//   					imgPos++;
//   				}
//   				pagerActive();
//   		});
// 	}

// 	//Function for movePrev Button
// 	function movePrev(moveWidth) {
// 		sliderWrap.animate({
//     		'margin-left': '+=' + moveWidth
//   			}, 500, function() {
//   				if (imgPos==1) {
//   					imgPos=length;
//   					sliderWrap.css('margin-left', -(width*length));
//   				}
//   				else if (pagerPos < imgPos) {
//   					imgPos = pagerPos;
//   				}
//   				else {
//   					imgPos--;
//   				}
//   				pagerActive();
//   		});
// 	}

// });