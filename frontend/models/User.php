<?php

namespace frontend\models;

use dektrium\user\models\User as BaseUser;
use dektrium\user\Finder;
use dektrium\user\helpers\Password;
use dektrium\user\Mailer;
use dektrium\user\Module;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\Application as WebApplication;
use yii\web\IdentityInterface;
use dektrium\user\models\Token;

class User extends BaseUser
{

    /**
     * This method is used to register new user account. If Module::enableConfirmation is set true, this method
     * will generate new confirmation token and use mailer to send it to the user.
     *
     * @return bool
     */
    public function register()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = $this->module->enableConfirmation ? null : time();
        $this->password     = $this->module->enableGeneratingPassword ? Password::generate(8) : $this->password;

        $this->trigger(self::BEFORE_REGISTER);

        if (!$this->save()) {
            return false;
        }

        if ($this->module->enableConfirmation) {
            /** @var Token $token */
            $token = Yii::createObject(['class' => Token::className(), 'type' => Token::TYPE_CONFIRMATION]);
            $token->link('user', $this);
        }

        //$this->mailer->sendWelcomeMessage($this, isset($token) ? $token : null);
        // TODO enviar correo de bienvenida avisando que la cuenta debe ser activada por un administrador
        $this->trigger(self::AFTER_REGISTER);

        return true;
    }




     public function sendEmail($email)
    {
        
        return Yii::$app->mailer->compose()
        
            ->setTo($this->getAttributes()['email'])
            ->setFrom([$email => 'Stock Manager'])
            ->setSubject(Yii::t('app', ' Welcome to StockManager'))
            ->setTextBody(Yii::t('app', ' Your application has been sent successfully. An administrator of the site will review it. You will be notified when your account is activated.'))
            ->send();
    }





}