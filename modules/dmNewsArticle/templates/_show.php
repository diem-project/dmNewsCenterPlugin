<?php // Vars: $dmNewsArticle

use_helper('Date');

$author = null;
if (sfConfig::get('app_dmNewsCenterPlugin_showAuthor')) {
    $author =  _tag('span', ' | ' . $dmNewsArticle->Author);
}

echo _open('div.clearfix');

echo _tag('h2.t_big', $dmNewsArticle->title);

echo _tag('h4.summary', $dmNewsArticle->summary);

echo _tag('p.dm_news_article_infos',
        _tag('span', format_date($dmNewsArticle->createdAt, 'D'))  .
        $author
        );

echo _media($dmNewsArticle->Image)->size(200, 200)->set('.image');


echo markdown($dmNewsArticle->body);

echo _close('div');