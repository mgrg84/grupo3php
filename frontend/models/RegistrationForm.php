<?php

namespace frontend\models;

use dektrium\user\models\RegistrationForm as RegistrationFormBase;
use dektrium\user\Module;
use Yii;
use yii\base\Model;

class RegistrationForm extends RegistrationFormBase {

	/**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }

        Yii::$app->session->setFlash(
            'info',
            Yii::t('app', 'Your application has been sent successfully. 
                An administrator of the site will review it. You will be notified when your account is activated.')
        );

        return true;
    }

}