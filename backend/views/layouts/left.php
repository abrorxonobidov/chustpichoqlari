<?
/**
 * @var $user \common\models\user\User
 */

$user = Yii::$app->user->identity;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/uploads/user-profile-photos/<?= $user->id ?>-main.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $user->getNameAndSurname() ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => Yii::t('main', 'Manyular'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('main', 'Tizimga kirish'), 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => Yii::t('main', 'Ro‘yxat'),
                        'icon' => 'list',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t('main', 'Ro‘yxat'),
                                'icon' => 'list-ul',
                                'url' => ['/lists/lists']
                            ],
                            [
                                'label' => Yii::t('main', 'Ro‘yxat kategoriyalari'),
                                'icon' => 'list-ol',
                                'url' => ['/lists/lists-category']
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('main', 'Mahsulotlar'),
                        'icon' => 'gift',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t('main', 'Mahsulotlar'),
                                'icon' => 'diamond',
                                'url' => ['/products/products']
                            ],
                            [
                                'label' => Yii::t('main', 'Mahsulot kategoriyalari'),
                                'icon' => 'list-alt',
                                'url' => ['/products/product-category']
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('main', 'Buyurtmalar'),
                        'icon' => 'calendar-check-o',
                        'url' => ['/orders/orders']
                    ],
                    [
                        'label' => Yii::t('main', 'To‘lovlar'),
                        'icon' => 'dollar',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t('main', 'Payme to‘lovlar'),
                                'icon' => 'dollar',
                                'url' => ['/transactions/transactions-payme']
                            ],
                            [
                                'label' => Yii::t('main', 'Click to‘lovlar'),
                                'icon' => 'dollar',
                                'url' => ['/transactions/transactions-click']
                            ],
                        ],
                    ],
                    [
                        'label' => 'Dev’s tools',
                        'icon' => 'gear',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'bar-chart', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
