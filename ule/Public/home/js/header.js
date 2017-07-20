/*
 *	公共js文件 
 * 
 * */


$(function(){
	
	/*固顶顶部导航js*/
	$('#header').navFixed();
	   $(window).scroll(function (){
	   		 var offsetTop = $(window).scrollTop();
	   		 if(offsetTop>135){
	   		 	$('#header').removeClass('header_shadow_none');
	   		 	$('#header').addClass('header_shadow_active');
	   		 }else{
	   		 	$('#header').addClass('header_shadow_none');
	   		 }
	   })
})