/*
 * 项目名称：悠乐1.0.1版本
 * 文件介绍：公用JS方法
 * 开发人员：344822559@qq.com
 * 开发时间：2017-04-27
 * */

/*
 * 统计输入字数
 * now:实时统计的字数
 * max:最大允许的字数
 * show：统计字数显示的jq对象，就是要把实时统计的对象往哪里显示
 * */
function checkTextLength(now,max,show){
	if(now>max){
		$(this).css('border','1px solid #ef8647');
		$(this).val($(this).val().substr(0,max));
		return false;
	}else{
		$(this).css('border','');
		show.text(now);
	}
}

/*
* 检测是否为空
* 返回boolen
* obj对象的值
*/
function checkEmpty(val){
	if ($.trim(val)=='') {
		return true;
	}else{
		return false;
	}
}

/*
* 检测字数是否合法
* 返回boolen
* obj对象的值
*/
function checkTextLengths(min,max,obj){

	if (min<obj && obj<max) {
		return true;
	}else{
		return false;
	}

}
