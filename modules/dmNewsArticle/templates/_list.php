<?php

// Vars: $dmNewsArticlePager

use_helper('Date');

echo $dmNewsArticlePager->renderNavigationTop();

echo _open('ul.elements');

foreach ($dmNewsArticlePager as $dmNewsArticle) {
    $author = null;
    if (sfConfig::get('app_dmNewsCenterPlugin_showAuthor')) {
        $author = _tag('span', $dmNewsArticle->Author) . ' | ';
    }

    echo _open('li.element');

    echo _tag('h2.t_medium', _link($dmNewsArticle));

    echo markdown($dmNewsArticle->summary, '.summary');

    echo _tag('p.dm_news_article_infos', _tag('span', format_date($dmNewsArticle->createdAt, 'D')) . ' | ' .
            $author .
            _link($dmNewsArticle)->text(__('Read more') . ' ...')
    );

    echo _close('li');
}

echo _close('ul');

echo $dmNewsArticlePager->renderNavigationBottom();