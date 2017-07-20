/*悠乐发布信息页面js*/
$(function() {


	$('body').on('click','.layui-form-select .layui-anim dd',function(){
		var titext=$(this).text();
		$(this).parent('dl').siblings('.layui-select-title').children('.layui-input').attr('value',titext);
		layui.form().render();
	});



	$('#money').bind('input propertychange', function() {

		var money=$(this).val();

		if (money<0) {$(this).val(0)}
		    
	});  


	$('.sevice_info').on('click',function(){
		$('#service_textarea').focus();
		$(this).hide();
	})


	// var welcomeHtml="<p style='color:#999;font-size:14px;'>请描述你,关于此次地接线路的详细规划信息：</p>";
	// welcomeHtml+="<p style='color:#999;font-size:14px;'>第一天....</p>";
	// welcomeHtml+="<p style='color:#999;font-size:14px;'>第二天....</p>";
	// welcomeHtml+="<p style='color:#999;font-size:14px;'>每天的预估花费(具体列举)....</p>";

	// //加载编辑框
	// var ue = UE.getEditor('Lineeditor',{
	// 	autoHeight: false,
	// 	zIndex:998,
	// 	//wordCount:true,
	// 	maximumWords:10000,
	// 	initialContent:welcomeHtml
	// });

	/*时间控件*/
	$('#startEnddate').dateRangePicker({
		showShortcuts: true,/*是否需要点击确定按钮*/
		format: 'YYYY-MM-DD',
		language:'cn',
		separator: " 至 ",
		minDays:1,
		maxDays:30,/*该参数定义日期范围的最大天数，如果设置为0，表示不限制最大天数。*/
		singleDate:false,/*设置为true可以选择单个的日期。*/
		showWeekNumbers : false, //是否显示第几周
		startDate: latertaday,/*日期选择的初始值*/
		endDate: laterMonth,/*日期选择的初始值*/
		autoClose: false,/*是否自动关闭选择框*/

	}).bind('datepicker-change', function(evt, obj) {
		/*绑定事件变化*/
		$('#startEnddate').val(obj.value);
		//alert('date1: ' + obj.date1 + ' / date2: ' + obj.date2);/*获取事件的开始和结束值*/
		//console.info(obj.date2)
		
	});



	/*layui form 表单控件加载*/
layui.use(['jquery','layer','laydate'], function(){
  $ = layui.jquery
  ,layer = layui.layer
  ,laydate = layui.laydate;


  var welcomeHtml="<p style='color:#999;font-size:14px;'>请描述你,关于此次地接线路的详细规划信息：</p>";
	welcomeHtml+="<p style='color:#999;font-size:14px;'>第一天....</p>";
	welcomeHtml+="<p style='color:#999;font-size:14px;'>第二天....</p>";
	welcomeHtml+="<p style='color:#999;font-size:14px;'>每天的预估花费(具体列举)....</p>";

	//加载编辑框
	var ue = UE.getEditor('Lineeditor',{
		autoHeight: false,
		zIndex:998,
		//wordCount:true,
		maximumWords:10000,
		initialContent:welcomeHtml
	});



	/*发布信息类别切换*/
	$('.send_info_box .chose_nav li').on('click',function(){
		$(this).addClass('active').siblings().removeClass('active');
		$('.send_info_box .info_box').eq($(this).index()).addClass('info_block').siblings().removeClass('info_block');

	})


	/*发布线路*/
	$('#addLines').on('click',function(){


		var welcomeHtml='<p id="initContent"></p><p style="color:#999;font-size:14px;">请描述你,关于此次地接线路的详细规划信息：</p><p style="color:#999;font-size:14px;">第一天....</p><p style="color:#999;font-size:14px;">第二天....</p><p style="color:#999;font-size:14px;">每天的预估花费(具体列举)....</p><p></p>';

		var title=$.trim($('#linestitle').val());
		var lines_thumb=$.trim($('#lines_thumb').val());
		var startEnddate=$.trim($('#startEnddate').val());
		var money=$.trim($('#money').val());
		var service_textarea=$.trim($('#service_textarea').val());
		var ContentText=$.trim(getContent());
		var selcountry=$('select[name="selcountry"]').val();
		if (selcountry=='') {
			selcountry=0
		}
		var selstate=$('select[name="selstate"]').val();
		if (selstate=='') {
			selstate=0
		}
		var selcity=$('select[name="selcity"]').val();
		if (selcity=='') {
			selcity=0
		}
		if (checkEmpty(title)) {
			layer.msg('标题不得为空！');
			$('#linestitle').focus();
			return false;
		}

		if (!checkTextLengths(10,100,title.length)) {
			layer.msg('标题字数必须在11到100之间！');
			$('#linestitle').focus();
			return false;
		}

		if (checkEmpty(lines_thumb)) {
			layer.msg('封面图不得为空!');
			return false;
		}

		if (checkEmpty(startEnddate)) {
			layer.msg('请选择行程开始日期和结束日期!');
			return false;
		}

		if (money=='') {
			layer.msg('收费不得为空!');
			return false;
		}

		if (1>money) {
			layer.msg('收费不得小于1!');
			return false;
		}

		if (checkEmpty(service_textarea)) {
			layer.msg('服务和报价说明不得为空!');
			$('.sevice_info').show();
			return false;
		}

		var hasContentText=$.trim(getContent());
		if (hasContentText==welcomeHtml||hasContentText=='') {
			layer.msg('线路规划详情不得为空!');
			return false;
		}

		$.ajax({
			type:"POST",
			url:addLinesSend,
			dataType:'json',
			data:{title:title,lines_thumb:lines_thumb,startEnddate:startEnddate,money:money,selcountry:selcountry,selstate:selstate,selcity:selcity,service_textarea:service_textarea,ContentText:ContentText},
			success:function(data){
				console.trace(data);
				switch(data.code){
					case 200:
					layer.msg(data.msg);
					location.reload();
					break;
					default :
					layer.msg(data.msg);
					break;
				}
			}

		})
		





	})



	


})

















	// 获得带格式的文本内容
	function getContent() {
	    var arr = [];
	    arr.push(UE.getEditor('Lineeditor').getContent());
	    return arr
	}

	// 获得带格式的纯文本内容
	 function getPlainTxt() {
	        var arr = [];
	        arr.push(UE.getEditor('Lineeditor').getPlainTxt());
	        return arr
	 }

	// 判断编辑器是否有内容
	 function hasContent() {
	    var arr = [];
	    arr.push(UE.getEditor('Lineeditor').hasContents());
	    return arr
	}

})


function checkArea(obj,type){

	countryid=$(obj).val();
	var selectName=$(obj).attr('name');
	var countryid=Number(countryid);

	 	$.ajax({
		type:"POST",
		url:getBack,
		dataType:'json',
		data:{id:countryid,type:type},
		success:function(data){
			//console.log(data)
			if (data.type=='state') {
				switch(data.status){
					case 300:
					var html='';
					for (var i=0; i < data.content.length; i++) {
						html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
					}
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().show();
					$('select[name="selcity"]').append(html);
					break;

					default :
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().hide();
				}

				return ;
			}

			switch(data.status){
				case 200:
				var html='';
				
				for (var i=0; i < data.content.length; i++) {
					html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
				}

				var cityHtml='';
				if (data.city.length) {

					for (var i=0; i < data.city.length; i++) {
						cityHtml+='<option value="'+data.city[i].id+'">'+data.city[i].name+'</option>';
					}

				}else{
					cityHtml='<option value="0">没有城市信息</option>';
				}

				$('select[name="selstate"]').parent().show();
				$('select[name="selstate"]').empty();
				$('select[name="selcity"]').empty();
				$('select[name="selstate"]').append(html);
				$('select[name="selcity"]').append(cityHtml);
				break;

				case 300:

				if (selectName=='selstate') {
					var html='';
					for (var i=0; i < data.content.length; i++) {
						html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
					}
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().show();
					$('select[name="selcity"]').append(html);
					
				}else{

					var html='';
					for (var i=0; i < data.content.length; i++) {
						html+='<option value="'+data.content[i].id+'">'+data.content[i].name+'</option>';
					}
					$('select[name="selstate"]').empty();
					$('select[name="selstate"]').parent().hide();
					$('select[name="selcity"]').empty();
					$('select[name="selcity"]').parent().show();
					$('select[name="selcity"]').append(html);
					
				}
				break;
				
				default :
      			$('select[name="selstate"]').empty();
				$('select[name="selcity"]').empty();
				$('select[name="selstate"]').parent().hide();
				$('select[name="selcity"]').parent().hide();

			}


		}

		
	})

}










/*关闭layer层*/
function product_close(){
	var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
	parent.layer.close(index); //再执行关闭 
}




function uploadInfoThumb(){

	 	var strs = new Array(); //定义一数组
        var pic1= $('input[name="file_face"]').val();
        strs = pic1.split('.');
        var suffix = strs [strs .length - 1];
        layui.use(['layer'], function(){
            	var layer=layui.layer;

        if (suffix != 'jpg' && suffix != 'gif' && suffix != 'jpeg' && suffix != 'png') {
            
            	layer.alert('请上传正确的图片类型！',{
            		btnAlign:'c',
            		title:'警告'
            	});
            	return false;
           
            
        }else{

        /*上传图片*/
        var formData = new FormData($( "#uploadForm" )[0]);
         var files = $('#file_face').prop('files');
		 var data = new FormData();
		 data.append('file_face', files[0]);
            $.ajax({
                url: coverthumb,
                type: "POST",
                data: data,
                processData: false,  // 告诉jQuery不要去处理发送的数据
                contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
                success:function(msg){
                	console.info(msg);
                	switch(msg.code){
						case 200:
							html="<img src='"+msg.thumb+"'/>";
							$('.send_thumb_box .defult_box').empty();
							$('#lines_thumb').val(msg.thumb);
							$('.send_thumb_box .defult_box').append(html);
							//layer.msg(msg.msg);
							break;
						default:
							layer.msg(msg.msg);
							break;
					}


                }
            });

        	

        }
    })
} 
