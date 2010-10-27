<?php

require_once dirname(__FILE__) . '/../lib/dmNewsLetterAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/dmNewsLetterAdminGeneratorHelper.class.php';

/**
 * dmNewsLetterAdmin actions.
 *
 * @package    LRCMS
 * @subpackage dmNewsLetterAdmin
 * @author     Thomas Ohms <http://www.lokarabia.de>
 * @version    SVN: $Id: actions.class.php 26 2010-10-02 18:35:29Z tohms $
 */
class dmNewsLetterAdminActions extends autoDmNewsLetterAdminActions {

    public function executeBatchSend(sfWebRequest $request) {

      foreach ($request->getParameter('ids') as $id) {

        $this->executeSend($request, $id);

      }

      $this->redirect('@'.$this->getDmModule()->getUnderscore());

    }

    public function executeSend(sfWebRequest $request, $id = null) {

      $single = false;
      
      if (null === $id || !is_numeric($id)) {
        $id = $request->getParameter('id', false);
        $single = true;
      }

      if ($id) {

        $contentHtml = null;
        $contentText = null;

        $newsletter = DmNewsLetterTable::getInstance()->findOneById($id);

        // fetch current newsletter categories subscribers
        $subscribers = DmNewsSubscriberCategoryTable::getInstance()
                ->createQuery('sc')
                ->select('sc.*, s.*')
                ->leftJoin('sc.Subscriber s')
                ->where('s.confirmed = ?', true)
                ->andWhereIn('sc.category', $newsletter->Categories->toKeyValueArray('id', 'id'))
                ->execute()
              ;

        if ($single) {
          $this->articles = array();
          $this->subject = $newsletter->subject;
          $this->subscriberCount = $subscribers->count();
        }


        foreach ($newsletter->Articles->getData() as $article) {
          $page = $article->getPage();
          $contentHtml .= $this->renderArticle($article, $page);
          $contentText .= $this->renderArticle($article, $page, false);
          if ($single) {
            $this->articles[] = $contentHtml;
          }
        }

        $mail = $this->getService('mail')->setTemplate('newsletter');
        $recipients = array();

        foreach ($subscribers as $subscriber) {
            $mail->addValues(array(
                'firstname' => $subscriber->Subscriber->firstname,
                'lastname' => $subscriber->Subscriber->lastname,
                'email' => $subscriber->Subscriber->email,
                'content_text' => $contentText,
                'content_html' => $contentHtml,
                'unsubscribe_parameter' => '?remove=' . $subscriber->subscriber,
                'edit_parameter' => '?edit=' . $subscriber->subscriber
            ));

            $recipients[$subscriber->Subscriber->email] = $subscriber->Subscriber->firstname . " " . $subscriber->Subscriber->lastname;
        }

        $mail = $mail->render();
        $mail->getMessage()->setTo($recipients);
        $mail->getMessage()->setSubject($newsletter->subject);

        $mail->send();

        $newsletter->set('sent_at', date("Y-m-d H:i"));
        $newsletter->save();

        $this->getUser()->logInfo($this->getI18n()->__('The newsletter "%subject%" was successfully sent to %count% recipient(s)', array(
            '%subject%' => $newsletter->subject,
            '%count%'   => $subscribers->count()
        )));
      }
      else
      {
        $this->getUser()->logInfo('A problem occured when sending the newsletter.');
      }


    }

    protected function renderArticle(DmNewsArticle $article, Doctrine_Record $page, $isHtml = true) {
        if ($isHtml) {
            $nl = "<br />";
            $sep = '<hr />';
            $title = '<p><h2>' . $article->title . '</h2>' . $nl;
            $content = nl2br($article->summary) . $nl . $nl;
            $articleUrl = dm::getHelper()->link($page)->text($this->getI18n()->__('Read more')) . '</p>' . $sep . $nl;
        } else {
            $nl = "\r\n";
            $sep = '-------------------------------------------------';
            $title = "*== " . $article->title . "==*" . $nl;
            $content = $article->summary . $nl . $nl;
            $articleUrl = dm::getHelper()->link($page)->getAbsoluteHref() . $nl . $sep . $nl . $nl;
        }

        return $title . $content . $articleUrl;
    }

}
