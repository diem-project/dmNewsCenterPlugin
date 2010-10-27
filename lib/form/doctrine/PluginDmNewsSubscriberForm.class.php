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

        $this->changeToEmail('email');

        //$this->setValidator('email', new sfValidatorEmail(array(), array('invalid' => 'Your email address is invalid!')));
    }

}