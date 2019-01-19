![image.png](https://upload-images.jianshu.io/upload_images/7728915-e0314c64ba25a082.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

YII中文文档
https://www.yiichina.com/doc/guide/2.0
#### 安装Yii
1. 安装composer
windows下载[Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)
百度经验：https://jingyan.baidu.com/article/eae078276ec3791fec5485c6.html
![image.png](https://upload-images.jianshu.io/upload_images/7728915-79a7abb6e910c01d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
2. 安装Yii
新建一个目录（我是在apache的www目录下面，因为在wamp可以访问www下面的文件），在这里目录下面运行以下命令

        composer create-project --prefer-dist yiisoft/yii2-app-basic basic
    这将在一个名为 basic 的目录中安装Yii应用程序模板的最新稳定版本  
    经过漫长的等待，在相对应的目录下面看到了下面这些文件
![image.png](https://upload-images.jianshu.io/upload_images/7728915-3b2a74c0a44bb25d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
3. 打开wamp,在地址栏输入localhost/Yii/basic/web/

https://blog.csdn.net/changemust/article/details/79486473

4. 目录主要文件及其作用
requirement.php: 检测系统环境，在浏览器访问的时候能在detail看到检测的结果。
config——>web.php:可以配置cookieValidationKey

#### Yii请求流程
![image.png](https://upload-images.jianshu.io/upload_images/7728915-03ea8e8097a296c9.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
重点关注：控制器（C），模型（M），视图（V）
##### PHP命名空间
主要作用：

* 用户编写的代码与PHP内部的类/函数/常量或第三方类/函数/常量之间的名字冲突。
* 很长的标识符名称(通常是为了缓解第一类问题而定义的)创建一个别名（或简短）的名称，提高源代码的可读性。
两个相同名字的类会报错，但如果是在不同命名空间之下的就不会报错。
所有常量、类和函数名都放在全局空间下，就和PHP支持命名空间之前一样。
http://www.runoob.com/php/php-namespace.html
##### 控制器
###### 新建控制器
**注意：以下的url是基于本机Yii模板中web中的index.php来输入的，应该具体问题具体分析**
在controller文件夹下面有SiteController.php控制器
我们要新建一个属于自己的控制器。
这个控制器必须以Controller结尾
在url输入
http://localhost/Yii/basic/web/index.php?r=hello/index
hello表示使用helloController控制器,index表示使用里面的index操作
r：redirect的简写
可以看到我们的页面已经成功显示出了

        namespace app\controllers;  //必须要在一个命名空间之内
        use yii\web\Controller;    //要继承的这个控制器在这个命名空间之内


        //所有控制器的类都必须继承于Controller这个类
        class HelloController extends Controller{
            public function actionIndex(){
                echo 'hello world';
            }
        }
###### 控制器处理请求
当我们在url中输入一些请求的参数例如http://localhost/Yii/basic/web/index.php?r=hello/index&id=20
要如何进行处理呢？
全局类Yii中从应用主体$app中加载应用组件request.
主要代码如下：

      public function actionIndex(){
        $request = \Yii::$app->request;//获取请求组件
        echo $request->get('id');
        // echo 'hello world';
    }
可以看到20
同时可以通过get 的第二个参数来设置默认参数。
   echo $request->get('id'，30);
如果没有&id参数没有输入，就会给id赋值。
所以，当我们http://localhost/Yii/basic/web/index.php?r=hello/index
还有post方法
$request->isGet
$request->isPost
###### 控制器响应处理
* 设置状态码

        $res = \Yii::$app->response;
        // $res->statusCode = '200';
        $res->statusCode = '500';
        //这里设置前端收到的响应码
![image.png](https://upload-images.jianshu.io/upload_images/7728915-8928b0bc12e114db.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
* 设置 Pragma

        $res = \Yii::$app->response;
        $res->headers->add('pragma','no-cache');
![image.png](https://upload-images.jianshu.io/upload_images/7728915-6bab384a2ef0bbba.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

* 设置location

重定向

      $this->redirect('https://www.baidu.com/?tn=93380420_hao_pg',302);
###### session处理

* 设置session

在php.ini中输入session.save_path : 用来搜索session存放的位置，输入之后得到

      session.save_path ="c:/wamp64/tmp"
也就是说session存放在tmp中
在controller的function输入

        $session = \Yii::$app->session;
        $session->open();
        //开启session

        if($session->isActive){
            echo 'session is active';
        }
        //判断是否处于开启状态
    
        $session->set('user','张三');
        $session['user'] = '张三';  //另外一种设置键值的方法
打开tmp中的文件，得到

    __flash|a:0:{}user|s:6:"张三";
取得对应的键值并打印出来

      echo $session->get('user');

删除：

     $session->remove('user');
     unset($session['user']);
 
###### session识别原理

![image.png](https://upload-images.jianshu.io/upload_images/7728915-bc65ee88c2afa732.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
##### cookie处理
* 添加cookie

        $cookies = \Yii::$app->response->cookies;
        $cookie_data = array('name'=>'张三','value'=>'888888');
        $cookies->add(new Cookie($cookie_data));
![image.png](https://upload-images.jianshu.io/upload_images/7728915-c557e87ef6f01dfa.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
当你把这里的value修改之后，你会发现application中对应的cookies的value发生了改变。
* 删除cookie

         $cookies->remove('张三');
![image.png](https://upload-images.jianshu.io/upload_images/7728915-d12108f6aacbb5f1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

* 取出cookies数据

        echo $cookies->getValue('张三');

* 对cookie进行加密处理

在config文件夹中web.php中的cookieValidationKey设置的值就是对cookie加密的值。

##### 视图
###### 视图的创建
在views文件夹中创建（要放在和控制器的名字相对应的文件夹中，例如控制器叫HelloController，那么我们的对应的视图文件就应该放在views文件夹中的hello文件夹中）
在控制器中要渲染对应的视图文件应该怎么办？

        return $this->renderPartial('index');

##### 视图的数据传递
* 传递字符串
在helloController.php中，我们应该这样写

        $hello_str = "hello everybody";
        //创建一个数组
        $data = array();
        //把需要传递给视图的数组，放在数组当中
        $data['view_hello_data'] = $hello_str ;

        return $this->renderPartial('index',$data);
        //第二个参数就是要传递的数据
    在对应的视图文件（views-hello-index.php）中，要对收到的数据进行展示。

        <h1><?=$view_hello_data;?></h1>
        <!-- 对传递过来的数组进行处理 -->
* 传递数组
       
          $test_arr = [1,2,3];
          $data = array();
          $data['view_test_arr'] = $test_arr;
          return $this->renderPartial('index',$data);
     在对应的视图中间中进行处理

        <h1><?=$view_test_arr[0];?></h1>
        <h1><?=$view_test_arr[2];?></h1>
###### 视图之数据安全
  如果用户输入的一些内容是需要被显示出来的。那么用户的输入的内容中嵌入<script>脚本是会被网页正常运行的，那么就会如果用户注入了恶意代码，就会.....(XSS)

        $hello_str = "hello everybody<script>alert(3);</script>";
所以我们就应该在对应的index.php中

        <?php
        use yii\helpers\Html;
        ?>
        <h1><?=Html::encode($view_hello_data);?></h1>
这个时候我们可以看到，没有弹出警告框，而是因为encode把scipt标签里面的内容处理了一下。
显示的页面是这个样子，把script里面的内容直接显示出来了。

![](https://upload-images.jianshu.io/upload_images/7728915-e62cafbf7c5a6bc5.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
我们还可以采用另外一种方式

        <?php
        use yii\helpers\Html;
        use yii\helpers\HtmlPurifier;
        ?>
        <h1><?=Html::encode($view_hello_data);?></h1>
        <h1><?=HtmlPurifier::process($view_hello_data);?></h1>
将js代码彻底过滤掉，下面是两种方式的对比。
![image.png](https://upload-images.jianshu.io/upload_images/7728915-0f2eef7eedea0d71.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

##### 数据模型之数据库配置
###### 新建数据库
新建yii数据库，在yii中新建一张表叫做books
id子增长就要设置表单中的A_I 一栏，打上勾（），然后左边的primary要改成index，其他的就不要填了。
config-db.php就可以配置数据库

        <?php

        return [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii',
            //yii是我们想要连接的那个数据库
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',

            // Schema cache options (for production environment)
            //'enableSchemaCache' => true,
            //'schemaCacheDuration' => 60,
            //'schemaCache' => 'cache',
        ];

新建数据库的时候遇到#1366的问题，因为字符集不同，只需要将数据库的字符集、表的字符集、各字段的字符集设为相同即可

###### 活动记录的创建
[Active Record](http://zh.wikipedia.org/wiki/Active_Record) 提供了一个面向对象的接口， 用以访问和操作数据库中的数据

model文件夹下面新建一个books.php
新建一个继承于ActiveRecord的class

        <?php
        namespace app\models;

        use yii\db\ActiveRecord;
        class Books extends ActiveRecord{
            public static function tableName(){
                return 'books';
            }
        }
这样就创建了一个activeRecord的类，就可以在控制器里面去调用它了。
此时在helloController中的actionIndex函数中。

            $sql = 'select * from books where id=1';
            $result = Books::findBySql($sql)->all();
            //findBySql()执行sql语句

            print_r($result);
![打印出来的.png](https://upload-images.jianshu.io/upload_images/7728915-2495ec66529e8a64.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
这里犯了一个错误，就是用echo来打印 \$result
但是echo输出一个或者多个字符串 ,\$result则是一个对象，所以肯定是不能显示出来
![image.png](https://upload-images.jianshu.io/upload_images/7728915-79240e1f98eff9c1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
###### 表单查询
可能存在SQL注入
原理
简单的说，把未经过滤和验证的数据直接拼装SQL语句，会存在SQL注入漏洞。
<?php
// 警告，以下是不安全的写法
   
        Yii::app()->db
        ->createCommand("DELETE FROM mytable WHERE id = " . $_GET['id'])
        ->execute();
        $comments = Comment::model->findAll("user_id = " . $_GET['id']);
上面示例中的第一个sql语句，如果GET参数是”4 or 1=1”,这会导致表中的所有数据被删除；
第二个sql语句中，如果GET参数是2 UNION SELECT ，会导致数据库的任意数据都被查询出来。
所以，在yii中，可以使用占位符的方式

// 安全

        $comments = Comment::model->findAllByAttributes(array("post_id" => $postId, "author_id" => $ids));
也就是说，在yii对应的函数中加上第二个参数
https://www.yiichina.com/topic/5530
其他相关的查询操作：

![image.png](https://upload-images.jianshu.io/upload_images/7728915-eea107114c409552.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

优化，将获取到的对象转换为数组。（asArray），数组占的内存比对象低。
![image.png](https://upload-images.jianshu.io/upload_images/7728915-f484f6df0b273354.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
batch后面的参数就是每次批量拿多少条数据。
![image.png](https://upload-images.jianshu.io/upload_images/7728915-22730bc73f32849e.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

###### 删除数据
![image.png](https://upload-images.jianshu.io/upload_images/7728915-07005751b350cb27.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
###### 添加数据
Test是那个表的名字
![image.png](https://upload-images.jianshu.io/upload_images/7728915-1e4196c700fcbeb6.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
插入新数据时，对用户的输入进行验证。
可以在对应的books里面进行操作。
在books中新增一个函数
![image.png](https://upload-images.jianshu.io/upload_images/7728915-635516d081e1d92a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
此时控制器的代码应该修改为
![image.png](https://upload-images.jianshu.io/upload_images/7728915-ca3a9464227fd5f7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
###### 数据修改
![image.png](https://upload-images.jianshu.io/upload_images/7728915-3345230c1be4cdbe.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
###### 关联查询

#### 作业部分
连接数据库并传递数据给视图（siteController.php）

    public function actionIndex()
    {
        $sql = 'select * from books';
        $result = Books::findBySql($sql)->all();
        //print_r($result);
        return $this->render('index',['result' => $result]);
    }

https://www.cnblogs.com/huanghaihua/p/4942098.html

鉴于这行代码的定义，应用处于开发模式下，按照上面的配置会打开 Gii 模块。你可以直接通过 URL 访问 Gii：
http://hostname/index.php?r=gii

    <p>
        <?= Html::a('Create Country', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
['create']就是要调用的那个函数
https://www.yiichina.com/tutorial/663

遇到了挺多数据库的问题
1364 Field 'author' doesn't have a default value
原来是忘记了在model里面设置规则了。
要把author那一段的也加进去


    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['title'], 'unique'],
            [['author'], 'required'],
            [['author'], 'string', 'max' => 100],
            [['author'], 'unique'],
        ];
    }

有两个键值的返回设置对应的规则,也可以写成下面这样

        return [
            [['name', 'author'], 'required'],
            [['name', 'author'], 'string', 'max' => 100],
        ];