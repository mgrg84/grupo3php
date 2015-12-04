<?php

namespace frontend\controllers;

use dektrium\user\controllers\RegistrationController;
use dektrium\user\Finder;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsuarioController extends RegistrationController
{
	/**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }
        /** @var RegistrationForm $model */
        
        $model = Yii::createObject(RegistrationForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $domicilio = Yii::$app->request->post()['ubicacionDomicilio'];
            $nick = Yii::$app->request->post()['register-form']['username'];
            
            $connection = Yii::$app->db;
            $connection->open();

            $command = $connection->createCommand("UPDATE user SET ubicacionDomicilio='".$domicilio."'WHERE username='".$nick."'");
            $command->execute();

            return $this->render('/message', [
                'title'  => Yii::t('user', 'Your account has been created'),
                'module' => $this->module,
            ]);
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
        /*
        */
    }
}