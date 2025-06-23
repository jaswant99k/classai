<?php

namespace SpondonIt\FCM;

use Illuminate\Notifications\Notification;
use App\Services\GoogleFCMTokenService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
/**
 * Class FcmChannel.
 */
class FcmChannel
{




    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var FcmMessage $message */
        $message = $notification->toFcm($notifiable);

        if (is_null($message->getTo()) && is_null($message->getCondition())) {
            if (! $to = $notifiable->routeNotificationFor('fcm', $notification)) {
                return;
            }

            $message->to($to);
        }

        $response_array = [];

        $googleTokenService = new GoogleFCMTokenService();

        $json = Storage::get(SaasDomain() . '-firebase-service-account.json');

        $data = json_decode($json, true);

        $accessToken = $googleTokenService->getCachedAccessToken();

        $projectId = $data['project_id'] ?? '';


        $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

        if (is_array($message->getTo())) {
            $chunks = array_chunk($message->getTo(), 1000);

            foreach ($chunks as $chunk) {
                $message->to($chunk);

                $response = Http::withToken($accessToken)->post($url, $message->formatData());

                array_push($response_array, \GuzzleHttp\json_decode($response->getBody(), true));
            }
        } else {
            $response = Http::withToken($accessToken)->post($url, $message->formatData());

            array_push($response_array, \GuzzleHttp\json_decode($response->getBody(), true));
        }

        return $response_array;
    }
}
