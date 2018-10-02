<?php

namespace common\components;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\i18n\MissingTranslationEvent;
use yii\httpclient\Client;

class YandexTranslation
{
    public function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $client = new Client();
        /* @var $messageSource \yii\i18n\DbMessageSource */
        $messageSource = $event->sender;
        $db = $messageSource->db;

        // Extract first part of "en-EN" form
        $sourceLang = explode('-', $messageSource->sourceLanguage)[0];
        $targetLang = explode('-', $event->language)[0];
        
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://translate.yandex.net/api/v1.5/tr.json/translate')
            ->setData([
                'key' => Yii::$app->params['translate_yandex_key'],
                'text' => $event->message,
                'format' => 'plain',
                'lang' => "$sourceLang-$targetLang",
            ])
            ->send();

        if ($response->isOk) {
            $result = $response->data['text'];
            
            $event->translatedMessage = ArrayHelper::getValue($result, '0');

            if ($event->translatedMessage) {
                // try to find message source
                $id = (new Query())->select(['id'])
                    ->from($messageSource->sourceMessageTable)
                    ->where(['category' => $event->category, 'message' => $event->message])
                    ->createCommand()
                    ->queryScalar();
                // if not found, insert a new one. Note: it's better to use "upsert" command (depending of the used DB engine)
                if (!$id) {
                    $db->createCommand()->insert($messageSource->sourceMessageTable, [
                        'category' => $event->category, 
                        'message' => $event->message            
                    ])->execute();
                    
                    $id = $db->getLastInsertId();
                    
                    // insert new translated message.
                    $db->createCommand()->insert($messageSource->messageTable, [
                        'id' => $id,
                        'language' => $event->language,
                        'translation' => $event->translatedMessage
                    ])->execute();
                } else {
                    $message = (new Query())->select(['id', 'translation'])
                        ->from($messageSource->messageTable)
                        ->where(['id' => $id, 'language' => $event->language])
                        ->createCommand()
                        ->queryOne();
                        
                    if (!$message) {
                        $db->createCommand()->insert($messageSource->messageTable, [
                            'id' => $id,
                            'language' => $event->language,
                            'translation' => $event->translatedMessage
                        ])->execute();
                    } elseif (!$message['translation']) {
                        $db->createCommand()->update($messageSource->messageTable, [
                            'translation' => $event->translatedMessage
                        ], ['id' => $message['id']])->execute();
                    }
                                    
                }
            }
        }
        /*if (!$event->translatedMessage) {
            $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
        }*/
        return null;
    }
}