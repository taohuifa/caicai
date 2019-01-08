<?php


// 参数获取
function get($obj, $key, $default)
{
    if (!isset($obj) || $obj == null) {
        return $default;
    }
    // 数组处理
    if (is_array($obj)) {
        $val = isset($obj[$key]) ? $obj[$key] : null;
        return ($val != null) ? $val : $default;
    }
    // 对象
    if (is_object($obj)) {
        $val = isset($obj->$key) ? $obj->$key : null;
        return ($val != null) ? $val : $default;
    }
    return $default;
}

// 输出堆栈
function print_stack_trace()
{
    $array = debug_backtrace();
    //print_r($array);//信息很齐全
    unset($array[0]);
    $html = "";
    foreach ($array as $row) {
        // $html .= $row['file'] . ':' . $row['line'] . '行,调用方法:' . $row['function'] . "<p>";
        $html .= $row['file'] . ':' . $row['line'] . '行,调用方法:' . $row['function'] . "\r\n";
    }
    return $html;
}

// 解析反射写入对象
function json_decode_object($obj, $json)
{
    // 判断对象
    if (empty($obj)) {
        error_log("empty obj! \r\n" . print_stack_trace());
        return false;
    }
    // 解析json数据
    $jobj = json_decode($json);
    // var_dump($json);
    if ($jobj == null) {
        return false;
    }
    $class_name = get_class($obj);
    $class = new ReflectionClass($class_name);
    // var_dump($class);
    if (empty($class)) {
        return false;
    }
    
    // 解析json数据, 遍历参数
    foreach ($jobj as $key => $value) {
        // echo $key . '=>' . $value . '<br>';
        if (!$class->hasProperty($key)) {
            continue;
        }
        // 获取属性并赋值
        $property = $class->getProperty($key);
        // var_dump($property);
        $property->setValue($obj, $value);
    }

    return true;
}


?>