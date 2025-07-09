<?php

if ($_POST['type']) g('wb_service.type', $_POST['type']);
if ($_POST['position']) g('wb_service.position', $_POST['position']);
if (g('website.mainColor')) g('wb_service.color', g('website.mainColor'));

str::msg('修改成功', 1);