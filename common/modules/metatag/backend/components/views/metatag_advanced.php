<?= $form->field($model->metatag, 'title')
      ->hint(Yii::t('app', 'Текст, отображаемый в строке заголовка веб-браузера посетителя при просмотре этой страницы')) 
?>

<?= $form->field($model->metatag, 'keywords')
      ->hint(Yii::t('app', 'Список ключевых слов, разделенных запятыми')) 
?>

<?= $form->field($model->metatag, 'description')->textArea()
      ->hint(Yii::t('app', 'Краткое изложение содержания страницы')) 
?>