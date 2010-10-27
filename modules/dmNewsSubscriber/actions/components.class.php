<?php
/**
 * Subscribers components
 * 
 * No redirection nor database manipulation ( insert, update, delete ) here
 */
class dmNewsSubscriberComponents extends myFrontModuleComponents
{

  public function executeForm()
  {
    $this->form = $this->forms['DmNewsSubscriber'];
  }


}
