<?php
    switch ($lyCssConf['type']) {
        case 'wb_products':
            $search = wb_products_search::all();
            break;
    }
?>
<link rel="stylesheet" href="/themes/__/filter/result/1.css" />
<script src="/themes/__/filter/result/1.js"></script>

<section class="lyfilter_result">
    <div class="lyfilter_result_box cw1600">
        <div class="lyfilter_result_title">筛选条件：</div>
        <div class="lyfilter_result_list"></div>
    </div>
</section>