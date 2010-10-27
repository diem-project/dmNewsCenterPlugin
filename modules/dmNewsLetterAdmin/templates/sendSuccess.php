<?php

echo _tag('div.dm_box_middle');

echo _tag('h2.dm_box.title', __('Newsletter "%1%" sent to %2% recipient(s) with following articles:', array('%1%' => $subject, '%2%' => $subscriberCount)));

echo _open('div.dm_box_inner');

foreach ($articles as $article) {
    echo _tag('div.dm_box_inner', $article);
}

echo _tag('div.dm_box_inner', _link('@dm_news_letter')->text(__('Back to newsletter list'))->set('.dm_medium_button'));

echo _close('div');

echo _close('div');
?>