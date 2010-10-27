<?php

/**
 * PluginDmNewsArticle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    DmNewsNewsPlugin
 * @subpackage DmNewsArticle
 * @author     Thomas Ohms <http://www.lokarabia.de>
 * @version    SVN: $Id: Builder.php 26 2010-10-02 18:35:29Z tohms $
 */
abstract class PluginDmNewsArticle extends BaseDmNewsArticle
{
    /**
     *
     * @return Doctrine_Collection
     */
    public function getPage() {
        $pageTable = DmPageTable::getInstance();

        $page = $pageTable->createQuery('p')
                ->addWhere('module = ?', array('dmNewsArticle'))
                ->addWhere('record_id = ?', array($this->get('id')))
                ->fetchOne();

        return $page;
    }

}