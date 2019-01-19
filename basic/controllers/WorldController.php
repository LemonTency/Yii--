<?php
namespace app\controllers;  //必须要在一个命名空间之内
use yii\web\Controller;    //要继承的这个控制器在这个命名空间之内
use yii\web\Cookie;  //要继承的这个cookie在这个命名空间之内
use app\models\Books;   //活动记录（数据库连接）的Test类

//所有控制器的类都必须继承于Controller这个类
class WorldController extends Controller{
    public function actionIndex(){
        return $this->render('index');
//-----------------视图渲染----------------

        // return $this->renderPartial('index');
//-----------------视图传递数据-------------
        // $hello_str = "hello everybody";
        // $test_arr = [1,2,3];
        //创建一个数组
        // $data = array();
        //把需要传递给视图的数组，放在数组当中
        // $data['view_hello_data'] = $hello_str ;
        // $data['view_test_arr'] = $test_arr;

        // return $this->renderPartial('index',$data);
        //第二个参数就是要传递的数据
//-------------数据传递安全------------------
        // $hello_str = "hello everybody<script>alert(3);</script>";
        //创建一个数组
        // $data = array();
        //把需要传递给视图的数组，放在数组当中
        // $data['view_hello_data'] = $hello_str ;

        // return $this->renderPartial('index',$data);

    }
}
?>