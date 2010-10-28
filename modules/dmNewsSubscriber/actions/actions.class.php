<?php
/**
 * Subscribers actions
 */
class dmNewsSubscriberActions extends dmFrontBaseActions
{

  public function preExecute() {
    
        $subscribers = DmNewsSubscriberTable::getInstance()->findBy('confirmed', false);
        
        if ($subscribers->count() > 0) {
            foreach ($subscribers->getData() as $subscriber) {
                $currentTime = time();
                $limit = sfConfig::get('app_dmNewsCenterPlugin_wait4ConfirmationHours') * 60 * 60;
                $registered = strtotime($subscriber['updated_at']);
                
                if (($currentTime - $registered) >= $limit) {
                    $subscriber->delete();
                }
            }
        }
        
        $subscribers->free();

        parent::preExecute();
    }

  public function executeFormWidget(dmWebRequest $request)
  {
    if ($request->hasParameter('confirm')) {
        $this->confirm($request->getParameter('confirm'));
    }

    if ($request->hasParameter('remove')) {
        $this->remove($request->getParameter('remove'));
    }

    if ($request->hasParameter('edit')) {
        $editSubscriber = DmNewsSubscriberTable::getInstance()->findOneById($request->getParameter('edit'));

        $form = new DmNewsSubscriberForm($editSubscriber);
    } else {
        $form = new DmNewsSubscriberForm();
    }
        
    if ($request->hasParameter($form->getName()) && $form->bindAndValid($request))
    {
      $subscriber = $form->save();

      $this->sendConfirmation(
              $subscriber->getFirstName(),
              $subscriber->getLastName(),
              $subscriber->getEmail(),
              $subscriber->getId()
              );

      $this->getUser()->setFlash('subscription_form_valid', true);

      $this->redirectBack();
    }
    
    $this->forms['DmNewsSubscriber'] = $form;
  }

  protected function confirm($id) {
      if (!is_numeric($id)) {
          return;
      }

      $this->email = null;

      $subscriber = DmNewsSubscriberTable::getInstance()->find($id);

      if ($subscriber === FALSE) {
          $this->getUser()->setFlash('confirm_mail_invalid', true);
      } else {
          $subscriber->set('confirmed', true);
          $subscriber->save();
          $this->getUser()->setFlash('confirm_mail_valid', true);
          $this->getUser()->setFlash('email', $subscriber->email);
      }

  }

  protected function remove($id) {
      if (!is_numeric($id)) {
          return;
      }

      $this->email = null;

      $subscriber = DmNewsSubscriberTable::getInstance()->find($id);

      if ($subscriber === FALSE) {
          $this->getUser()->setFlash('remove_mail_invalid', true);
      } else {
          $this->getUser()->setFlash('remove_mail_valid', true);
          $this->getUser()->setFlash('email', $subscriber->email);
          $subscriber->delete();
      }
  }

  protected function sendConfirmation($first_name, $last_name, $email, $id) {
      $confirm = '?confirm=' . $id;

      $this->getService('mail')
              ->setTemplate('confirm_newsletter_subscription')
              ->addValues(array(
                  'first_name'   => $first_name,
                  'last_name'    => $last_name,
                  'email'       => $email,
                  'confirm_parameter' => $confirm,
                  'confirm_limit'=> sfConfig::get('app_dmNewsCenterPlugin_wait4ConfirmationHours')
              ))
              ->send();
  }

}
