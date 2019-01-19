<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="site-index">

    <div class="content">
    <div class="search">
        <form class="form-inline" role="form">
            <div class="form-group">
                <label class="sr-only" for="name">书名</label>
                <input type="text" class="form-control" id="name" placeholder="请输入书名">
            </div>
            <?= Html::a('查找', ['search'], [
                        'class' => 'btn btn-default',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
            <?= Html::a('新增', ['create'], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
            <!-- 需要一个id -->
    </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>书籍ID</th>
                <th>书籍</th>
                <th>作者</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $value) :?>
                <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['title']?></td>
                <td><?=$value['author']?></td>
                <td width="50px">
                    <?= Html::a('删除', ['delete'], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '你确定要删除这一项吗?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
                <td width="50px">
                    <?= Html::a('修改', ['delete'], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
                <td></td>
                </tr>
                <?php endforeach;?>
        </tbody>
    </table>

    </div>
</div>
