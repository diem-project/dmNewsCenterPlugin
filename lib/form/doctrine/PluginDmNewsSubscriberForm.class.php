<?php

/**
 * PluginDmNewsSubscriber form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 26 2010-10-02 18:35:29Z tohms $
 */
abstract class PluginDmNewsSubscriberForm extends BaseDmNewsSubscriberForm {

    public function setup() {
        parent::setup();

        unset($this['is_confirmed']);
        
        $this->changeToEmail('email');

        $category_query = DmNewsCategoryTable::getInstance()
                ->createQuery('c')
                ->withI18n()
                ->where('cTranslation.is_active = ?', true)
                ->andWhere('c.is_registrable = ?', true)
                ;

        if ($category_query->count() > 0) {
          $this->widgetSchema['categories_list']->setLabel('Newsletters');
          $this->widgetSchema['categories_list']->setOption('query', $category_query);
        } else {
          unset($this['categories_list']);
        }

        //$this->setValidator('email', new sfValidatorEmail(array(), array('invalid' => 'Your email address is invalid!')));
    }

}
