<?php
/**
 * Subscribers actions
 */
class dmNewsCategoryActions extends myFrontModuleActions
{

  public function executeFormWidget(dmWebRequest $request)
  {
    $form = new DmNewsCategoryForm();
        
    if ($request->hasParameter($form->getName()) && $form->bindAndValid($request))
    {
      $form->save();
      $this->redirectBack();
    }
    
    $this->forms['DmNewsCategory'] = $form;
  }


}
