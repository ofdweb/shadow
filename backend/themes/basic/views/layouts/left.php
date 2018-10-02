
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => //\backend\components\MenuManager::mainMenu()
                [
                    ['label' => Yii::t('app', 'Содержимое'), 'options' => ['class' => 'header']],
                    [
                        'label' => Yii::t('app', 'Страницы'), 'icon' => 'clipboard', 'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/page']],
                            ['label' => Yii::t('app', 'Добавить страницу'), 'icon' => 'copy', 'url' => ['/page/default/create']],
                        ],
                    ], [
                        'label' => Yii::t('app', 'Статьи'), 'icon' => 'newspaper-o', 'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/article']],
                            ['label' => Yii::t('app', 'Добавить статью'), 'icon' => 'copy', 'url' => ['/article/default/create']],
                        ],
                    ], [
                        'label' => Yii::t('app', 'Товары'), 'icon' => 'shopping-cart', 'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/product']],
                            ['label' => Yii::t('app', 'Добавить товар'), 'icon' => 'copy', 'url' => ['/product/default/create']],
                        ],
                    ], [
                        'label' => Yii::t('app', 'Веб-формы'), 'icon' => 'check-square-o', 'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Контакты'), 'icon' => 'dot-circle-o', 'url' => ['/webform/default/form', 'id' => 1]],
                            ['label' => Yii::t('app', 'Обратный звонок'), 'icon' => 'dot-circle-o', 'url' => ['/webform/default/form', 'id' => 2]],
                        ],
                    ],
                  
                    ['label' => Yii::t('app', 'Таксономия'), 'options' => ['class' => 'header']],
                    [
                      'label' => Yii::t('app', 'Теги'), 'icon' => 'tag', 'url' => '#',
                      'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/tag']],
                            ['label' => Yii::t('app', 'Добавить тег'), 'icon' => 'copy', 'url' => ['/tag/default/create']],
                       ],
                    ], [
                      'label' => Yii::t('app', 'Опции товаров'), 'icon' => 'tags', 'url' => '#',
                      'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/tag/options']],
                            ['label' => Yii::t('app', 'Добавить опцию'), 'icon' => 'copy', 'url' => ['/tag/options/create']],
                       ],
                    ],
                  
                    ['label' => Yii::t('app', 'Меню'), 'options' => ['class' => 'header']],
                    [
                      'label' => Yii::t('app', 'Главное меню'), 'icon' => 'indent', 'url' => '#',
                      'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/menu/main/index']],
                            ['label' => Yii::t('app', 'Добавить ссылку'), 'icon' => 'copy', 'url' => ['/menu/main/create']],
                        ],
                    ], [
                      'label' => Yii::t('app', 'Каталог товаров'), 'icon' => 'indent', 'url' => '#',
                      'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/menu/catalog/index']],
                            ['label' => Yii::t('app', 'Добавить ссылку'), 'icon' => 'copy', 'url' => ['/menu/catalog/create']],
                        ],
                    ],
                  
                    ['label' => Yii::t('app', 'Пользователь'), 'options' => ['class' => 'header']],
                    [
                        'label' => Yii::t('app', 'Пользователи'), 'icon' => 'user', 'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Список'), 'icon' => 'list', 'url' => ['/user']],
                            ['label' => Yii::t('app', 'Добавить пользователя'), 'icon' => 'copy', 'url' => ['/user/default/create']],
                        ],
                    ],
                  
                    ['label' => Yii::t('app', 'Настройки'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app', 'Системные'), 'icon' => 'cog', 'url' => ['/setting/system']],
                    ['label' => Yii::t('app', 'Информеры'), 'icon' => 'area-chart', 'url' => ['/setting/informer']],
                  
                    ['label' => Yii::t('app', 'Отчеты'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app', 'Сервер'), 'icon' => 'laptop', 'url' => ['/report/configuration']],
                    [
                      'label' => Yii::t('app', 'Логирование'), 'icon' => 'database', 'url' => '#',
                      'items' => [
                            ['label' => Yii::t('app', 'Действия'), 'icon' => 'exchange', 'url' => ['/report/logs/exchange']],
                       ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
