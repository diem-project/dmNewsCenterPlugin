
<?php

// Vars: $form

if ($sf_user->getFlash('subscription_form_valid')) {
    echo _tag('div.success',
            _tag('p', __('Thank you for your subscription.')) .
            _tag('p', __('We have send an email to your email address with a confirmation link.')) .
            _tag('p', __('Please follow this link to finish your subscription.'))
    );
} elseif ($sf_user->getFlash('confirm_mail_valid')) {
    echo _tag('p.success', __('You successfully confirmed your mail address %1% for our newsletter.', array('%1%' => $sf_user->getFlash('email'))));
} elseif ($sf_user->getFlash('remove_mail_valid')) {
    echo _tag('p.form_valid',
            __('You successfully unsubscribed your email %1% from our newsletter.', array('%1%' => $sf_user->getFlash('email')))
            );
} else {

    if ($sf_user->getFlash('confirm_mail_invalid')) {
        echo _tag('p.error',
                __('Could not find your mail address. Maybe you have reached the limit of %1% hour(s) to confirm and you have to register again.',
                        array('%1%' => sfConfig::get('app_dmNewsLetterPlugin_wait4ConfirmationHours'))
                )
        );
    }

    if ($sf_user->getFlash('remove_mail_invalid')) {
        echo _tag('p.error',
                __('We could not find your mail address in our database. If you still receive our newsletter, please contact us.')
                );
    }

    echo $form;

    /*echo $form->open('.suscription_form');

    echo _tag('ul',
            _tag('li', $form['firstname']->label()->field()->error()) .
            _tag('li', $form['lastname']->label()->field()->error()) .
            _tag('li', $form['email']->label()->field()->error())
    );

    echo $form->renderHiddenFields();

    echo $form->submit(__('Subscribe'), '.submit_wrap');

    echo $form->close();*/
}
