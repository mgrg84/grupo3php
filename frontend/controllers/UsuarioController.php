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

    /**
     * Displays page where user can create new account that will be connected to social account.
     *
     * @param string $code
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConnect($code)
    {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'connect',
            'username' => $account->username,
            'email'    => $account->email,
        ]);

        if ($user->load(Yii::$app->request->post()) && $user->create()) {
            $account->connect($user);
            $user->updateAttributes(['confirmed_at' => null]);
            $domicilio = Yii::$app->request->post()['ubicacionDomicilio'];
            $nick = Yii::$app->request->post()['User']['username'];
            
            $connection = Yii::$app->db;
            $connection->open();

            $command = $connection->createCommand("UPDATE user SET ubicacionDomicilio='".$domicilio."'WHERE username='".$nick."'");
            $command->execute();

            Yii::$app->session->setFlash('info', Yii::t('app', 
                'Your application has been sent successfully.
                An administrator of the site will review it. 
                You will be notified when your account is activated.'));
            return $this->redirect(array('/site/index'));
            // TODO Enviar correo con el mismo mensaje.

            


        }

        return $this->render('connect', [
            'model'   => $user,
            'account' => $account,
        ]);

    }

}