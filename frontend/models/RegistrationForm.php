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
            Yii::t('app', ' Your application has been sent successfully. 
                An administrator of the site will review it. You will be notified when your account is activated.')
        );

         $user->sendEmail(Yii::$app->params['adminEmail']);
         //$user->getAttributes()['email'];
       

        return true;
    }



//ESTA ES LA QUE ENVIA EN FORMA CORRECTA
      public function sendEmail($email)
    {
        
        /*return Yii::$app->mailer->compose()
        
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->send();*/

             return Yii::$app->mailer->compose()
        
            ->setTo([$this->email => $this->username])
            ->setFrom($email)
            ->setSubject(Yii::t('app', ' Welcome to StockManager'))
            ->setTextBody(Yii::t('app', ' Your application has been sent successfully. An administrator of the site will review it. You will be notified when your account is activated.'))
            ->send();


    }









}
