//删除左右两端的空格
function trim(str){ 
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
//转跳网址
function goUrl(url) {
    if (!url) {
        return false;
    }
    location.href  = url;
}
//添加
function add(url) {
    if (!url) {
        return false;
    }
    location.href  = url;
}

//删除
function del(url) {
    if (!url) {
        layer.alert('请选择删除项！', {
            icon: 2
        });
        return false;
    }

    layer.confirm('确实要永久删除选择项吗？', {
        btn: ['确定', '取消'] //按钮
    }, function() {
        location.href  = url;
    });
    
}
//批量删除
function delAll(){
    //if 没有被选中的checkbox
    if (!getCheckboxNum()){
        layer.alert('请选择项！', {
            icon: 2
        });
        return false;
    }

    layer.confirm('确实要永久删除选择项吗？', {
        btn: ['确定', '取消'] //按钮
    }, function() {
        document.getElementById("form_do").submit(); 
    });
      

}

//批量确认通用
function doConfirmBatch(url, str){
    //if 没有被选中的checkbox
    if (!getCheckboxNum()){
        layer.alert('请选择项！', {
            icon: 2
        });
        return false;
    }
    layer.confirm(str, {
        btn: ['确定', '取消'] //按钮
    }, function() {
        var form_do = document.getElementById("form_do"); 
        form_do.action = url;
        form_do.submit(); 
    });

}



//批量通用(无确认)
function doGoBatch(url, str){
    //if 没有被选中的checkbox
    if (!getCheckboxNum()){
        layer.alert('请选择项！', {
            icon: 2
        });
        return false;
    }
    var form_do = document.getElementById("form_do"); 
    form_do.action = url;
    form_do.submit();       

}

//全部确认通用
function doConfirmAll(url, str){

    layer.confirm(str, {
        btn: ['确定', '取消'] //按钮
    }, function() {
        var form_do = document.getElementById("form_do"); 
        form_do.action = url;
        form_do.submit(); 
    });     

}

//直接提交
function doGoSubmit(url, formid){
    if (formid.length == 0) {
        layer.alert('formid empty！', {
            icon: 2
        });
        return false;
    }
    var form_do = document.getElementById(formid); 
    form_do.action = url;
    form_do.submit();       

}



//批量通过审核
function toGetSubmit(url, mode, depr){
    var keyValue = getCheckValues();
    if (depr == '') {
        depr = '/';
    }
    if (!keyValue){
        layer.alert('请选择项！', {
            icon: 2
        });
        return false;
    }

    if (mode == 0) {
        location.href = url+"&key="+keyValue;
    }else {
        location.href = url+depr+"key"+depr+keyValue;
    }       
    
}

//确认,跳转网址
function toConfirm(url, str){

    layer.confirm(str, {
        btn: ['确定', '取消'] //按钮
    }, function() {
        location.href  = url;
    });      

}


//获取Checkbox被选择个数
function getCheckboxNum(){
   var checkbox = document.getElementsByName("key[]");
   var j = 0; // 用户选中的选项个数
   for(var i=0;i<checkbox.length;i++){
      if(checkbox[i].checked){
          j++;
      }
   }
   return j;

}
//设置Checkbox状态
function setCheckbox(flag){
    flag = flag? true : false;
    var checkbox = document.getElementsByName("key[]");
    for(var i=0;i<checkbox.length;i++){
        if (!checkbox[i].disabled) {        
            checkbox[i].checked = flag;
        }
    }

}

function getCheckValues(){
    var obj = document.getElementsByName('key[]');
    var result ='';
    var j= 0;
    for (var i=0;i<obj.length;i++){
            if (obj[i].checked===true){
                result += obj[i].value+",";
                j++;
            }
    }
    return result.substring(0, result.length-1);
}


function switchTab(name,sclass,cnt,cur){
        for(i=1;i<=cnt;i++){
            if(i==cur){
                 $('#div_'+name+'_'+i).show();
                 $('#tab_'+name+'_'+i).addClass(sclass);
            }else{
                 $('#div_'+name+'_'+i).hide();
                 $('#tab_'+name+'_'+i).removeClass(sclass);
            }
        }
    }



$(function(){
    //选中列表行变色
    $(".list tr").mouseover(function(){
        $(this).addClass("currow");
    }).mouseout(function(){
        $(this).removeClass("currow");
    });
    //全选/取消
    $("#check").click(function(){

        //attr('checked')不管用1.7+后  
        //var checked = $(this).prop('checked');//this.checked;//IE9+
        var checked = $(this).prop('checked');   
        if(checked){
            setCheckbox(true);
        }else{
            setCheckbox(false);
        }

    });
    
    
});
