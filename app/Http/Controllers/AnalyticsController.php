<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AnalyticsController extends Controller
{
    public function track(Request $request)
    {
        $ip = $request->json('ip');
        $city = $request->json('city');
        $country = $request->json('country');
        $userAgent = $request->json('user_agent');

        // добавил базовый рейтлимитинг, чтобы на всякий случай не забить бд лишними логами
        $lastVisitKey = "visit_last_{$ip}";
        if (Cache::has($lastVisitKey)) {
            return response()->json(['status' => 'throttled'], 429);
        }
        Cache::put($lastVisitKey, true, 5); // не более одного лога в 5 сек

        // более 10 логов в минуту = блокируем на 1 минуту
        $visitCountKey = "visit_count_{$ip}";
        $blockedKey = "visit_blocked_{$ip}";

        if (Cache::has($blockedKey)) {
            return response()->json(['status' => 'blocked'], 429);
        }

        $currentCount = Cache::get($visitCountKey, 0);
        if ($currentCount >= 10) {
            Cache::put($blockedKey, true, 60);
            return response()->json(['status' => 'blocked'], 429);
        }

        // продляем жизнь кешу (TTL 60 сек)
        Cache::put($visitCountKey, $currentCount + 1, 60);

        // сохраняем в БД
        Visit::create([
            'ip' => $ip,
            'city' => $city,
            'country' => $country,
            'user_agent' => $userAgent,
        ]);

        return response()->json(['status' => 'success']);
    }
}
