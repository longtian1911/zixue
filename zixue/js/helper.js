/*
 * @Descripttion: 这是一个文件
 * @version: 1.0.0
 * @Author: 爱唯主机
 * @link: https://www.aiweiidc.com
 * @Date: 2019-08-05 20:25:31
 * @LastEditors: 爱唯主机
 * @LastEditTime: 2019-08-15 12:58:16
 */
// 兼容各个浏览器的获取完整css样式的写法
//参数一：为节点对象， 参数二：需要获取的css属性
function getStyle(node,styleName){
    //currentStyle只能获取ie的 另一个可以获取谷歌和火狐的
   if(node.currentStyle){
       return node.currentStyle[styleName];
   }else{
       return getComputedStyle(node)[styleName];
   }
}

//自定义事件监听函数
function addEvent(ele, type, fn){
    if(window.addEventListener){
        ele.addEventListener(type, fn);
    }else{
        ele.attachEvent('on'+type, fn);
    }
}

//自定义事件移除函数
function removeEvent(ele, type, fn){
    if(window.removeEventListener){
        ele.removeEventListener(type, fn);
    }else{
        ele.detachEvent('on'+type, fn);
    }
}

//阻止时间冒泡 参数一：为事件对象
function zuzhi(evt){
    if(window.event){
        window.event.cancelBubble = true;
    }else{
        evt.stopPropagation();
    }
}

//阻止标签的默认行为 例如：a标签的跳转，提交按钮等 参数一：为事件对象
function biaoqianzhuzhi(evt){
    if(window.event){
        //ie
        window.event.returnValue = false;
    }else{
        //非ie浏览器
        evt.preventDefault();
    }
}