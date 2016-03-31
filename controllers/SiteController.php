<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TestForm;
use app\models\Comments;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionHello($mes = 'Привет Мир!!!' ) {
        return $this->render('hello', ['mes' => $mes]);
    }
    public function actionForm2() {
        $form = new TestForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $name = Html::encode($form->name);
            $email = Html::encode($form->email);
            
            $form->file = UploadedFile::getInstance($form, 'file');
            $form->file->saveAs('photo/'.$form->file->baseName.'.'.$form->file->extension);        
        } else {
           $name = '';
           $email = '';
        }
        return $this->render('form2', ['form' => $form,'name' => $name]);
    }   
    public function actionComments() {
        //$comments = Comments::find()->all();
        $comments = Comments::find();
        
        $pagination = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $comments->count()
        ]);
        
        $comments = $comments->offset($pagination->offset)->limit($pagination->limit)->all();
        
        $cookies = \Yii::$app->request->cookies; // 
        
        return $this->render('comments',[
            'comments' => $comments,
            'pagination' => $pagination,
            //'name'=> Yii::$app->session->get('name') // передоваемое значение берется из сессии
            'name' => $cookies->getValue('name') // передоваемое значение берется из Cookies
                ]);
    }
    
    public function actionUser() {
        $name = Yii::$app->request->get('name','Гость');
        
        // Сохранение данных в сессии
        //$session = Yii::$app->session;
        //$session->set('name', $name);
        // $session->has('name')    // проверить на существование
        //$session->remove('name'); // убрать переменную из сессии
        
        // Сохранение данных в cookies
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('name');
        $cookies->add(new \yii\web\Cookie([
            'name' => 'name',
            'value' => $name
        ]));
        return $this->render('user',[
            'name' => $name
        ]);
    }

}