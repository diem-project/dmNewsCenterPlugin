<?php
/*

 * actions.class.php
 *
 * Copyright (c) 2010 Thomas Ohms <http://www.lokarabia.de>.
 *
 * This file is part of dmNewsCenterPlugin.
 *
 * dmNewsCenterPlugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * dmNewsCenterPlugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with dmNewsCenterPlugin.  If not, see <http ://www.gnu.org/licenses/>.
 */

/**
 * Articles actions
 */
class dmNewsArticleActions extends myFrontModuleActions
{
    public function executeFeed($request) {
        $articles = Doctrine_Query::create()->from('DmNewsArticle a')
                ->withI18n()
                ->where('aTranslation.is_active = ?', true)
                ->orderBy('aTranslation.created_at DESC')
                ->limit(sfConfig::get('app_dmNewsCenterPlugin_maxFeedItems'))
                ->execute();

        $this->feed = new sfRssFeed();

        $this->feed->setAuthorName(sfConfig::get('app_dmNewsCenterPlugin_feedAuthor'));

        $articleUrl = $this->getHelper()->link('dmNewsArticle/list')->getAbsoluteHref();

        $this->feed->setLink($articleUrl);

        foreach ($articles as $article) {
            $item = new sfFeedItem();

            $item->setTitle($article->title);
            $item->setLink($this->getHelper()->link($article)->getAbsoluteHref());

            if (sfConfig::get('app_dmNewsCenterPlugin_showAuthor')) {
                $item->setAuthorName($article->Author);
            }

            $item->setUniqueId($article->title . ' (' . $article->id . ')');

            $dateObject = new DateTime($article->createdAt);
            $item->setPubdate($dateObject->format('U'));

            $item->setDescription(
                    $this->getHelper()->media($article->Image)->size(300, 200) .
                    $this->getService('markdown')->toHtml($article->body)
                    );

            $this->feed->addItem($item);
        }

        $this->setLayout(false);
    }

}
