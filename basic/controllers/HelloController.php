<?php
namespace app\controllers;  //必须要在一个命名空间之内
use yii\web\Controller;    //要继承的这个控制器在这个命名空间之内
use yii\web\Cookie;  //要继承的这个cookie在这个命名空间之内
use app\models\Books;   //活动记录（数据库连接）的Test类

//所有控制器的类都必须继承于Controller这个类
class HelloController extends Controller{
    public function actionIndex(){

        //-----------处理请求----------------
        // $request = \Yii::$app->request;//获取请求组件
        // echo $request->get('id',30);
        // echo '<br/>';
        //30是默认参数
        // echo 'hello world';

        // if($request->isGet){
        //     echo 'this is Get';
        // }
        //判断是否是get请求

        //-----------响应处理------------------
        // $res = \Yii::$app->response;
        // $res->statusCode = '200';
        // $res->statusCode = '500';
        //这里设置前端收到的响应码


        //---------设置pragma---------------------
        // $res = \Yii::$app->response;
        //$res->headers->add('pragma','max-age=5');//添加
        //$res->headers->set('pragma','no-cache');//修改
        // $res->headers->remove('pragma');//删除

        //-------跳转------------------------
        // $res = \Yii::$app->response;
        // $res->headers->add('location','https://www.baidu.com/?tn=93380420_hao_pg');
        // $this->redirect('https://www.baidu.com/?tn=93380420_hao_pg',302);

        //-------session处理----------------
        // $session = \Yii::$app->session;
        // $session->open();
        //开启session

        // if($session->isActive){
        //     echo 'session is active';
        //     echo '<br/>';
        // }
        //判断是否处于开启状态
    
        //$session->set('user','张三');
        // $session['user'] = '张三';
        //另外一种设置键值的方法
        // $session->remove('user');
        //unset($session['user']);
        // echo $session->get('user');
//------------------cookies---------------
        // $cookies = \Yii::$app->response->cookies;
        // $cookie_data = array('name'=>'张三','value'=>'8800008888');
        // $cookies->add(new Cookie($cookie_data));
        // $cookies->remove('张三');
        // $cookies = \Yii::$app->request->cookies;
        // echo $cookies->getValue('张三');

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
//--------------连接数据库--------------------
            $sql = 'select * from books where id=1';
            $result = Books::findBySql($sql)->all();
            //findBySql()执行sql语句

            print_r($result);
//--------------占位符防止用户乱输入---------------
            $id = '1 or 1=1';
            //如果用户这样输入的话就相当于输入select * from ...会查询到表里所有的信息
            //所以要进行处理
            $sql = 'select * from books where id='.$id;
            //用拼接字符串的形式来通过用户的输入进行查询
            $result = Books::findBySql($sql)->all();
            //findBySql()执行sql语句

            print_r($result);

    }
}
?>