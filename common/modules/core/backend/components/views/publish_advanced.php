<?= $form
    ->field($model, 'status_id')
    ->dropDownList($model::statusList()) 
?>