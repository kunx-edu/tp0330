<?php

/**
 * 将模型的错误信息转换成一个有序列表。
 * @param \Think\Model $model 模型对象
 * @return string
 */
function get_error(\Think\Model $model) {
    $errors = $model->getError();
    if (!is_array($errors)) {
        $errors = [$errors];
    }

    $html = '<ol>';
    foreach ($errors as $error) {
        $html .= '<li>' . $error . '</li>';
    }
    $html .= '</ol>';
    return $html;
}

/**
 * 将一个关联数组转换成下拉列表
 * @param array  $data        关联数组,二维数组.
 * @param string $name_field  提示文本的字段名.
 * @param string $value_field value数据的字段名.
 * @param string $name        表单控件的name属性.
 * @return string 下拉列表的html代码.
 */
function arr2select(array $data, $name_field = 'name', $value_field = 'id', $name = '',$default_value='') {
    $html = '<select name="' . $name . '" class="' . $name . '">';
    $html .= '<option value=""> 请选择 </option>';
    foreach ($data as $key => $value) {
        //由于get和post提交的数据都是字符串,所以可能存在数字0和空字符串相等的问题
        //我们将遍历的数据变成string,然后强制类型比较.
        if((string)$value[$value_field] === $default_value){
            $html .= '<option value="' . $value[$value_field] . '" selected="selected">' . $value[$name_field] . '</option>';
        }else{
            $html .= '<option value="' . $value[$value_field] . '">' . $value[$name_field] . '</option>';
        }
    }
    $html .= '</select>';
    return $html;
}

/**
 * 加盐加密
 * @param string $password 原密码
 * @param string $salt     盐
 */
function salt_mcrypt($password,$salt){
    return md5(md5($password).$salt);
}
