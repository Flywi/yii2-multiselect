# yii2-multiselect
![example](https://github.com/Flywi/yii2-multiselect/blob/master/example.png)
## 安装

推荐使用

```
$ php composer.phar require flywi/yii2-multiselect"
```

## 使用
在`ActiveForm`中使用:
```php
...
echo $form->field($model, 'attributeId')->widget(\flywi\select\MultiSelectWidget::class, [
    'data' => [
      // select options list(key => value)
    ],
    'clientOptions' => [
    
    ],
]);
...
```
## 其他
clientOptions [ 配置参考 ](https://github.com/crlcu/multiselect)
