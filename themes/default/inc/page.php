<?php if($page_list['total_page']>1){?>
<div id="page" wow='fadeInUp'>
    <a href="?pg=1" class="pn end box m-pic block trans l"><img src="/images/pn-end.svg" alt="" class="svg trans"></a>	

    <?=$page_list['html'];?>

    <a href="?pg=<?=$page_list['total_page']?>" class="pn end box m-pic block trans r"><img src="/images/pn-end.svg" alt="" class="svg trans"></a>
</div>
<?php }?>