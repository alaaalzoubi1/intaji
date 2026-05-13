<?php

namespace App\Http\Controllers\Api;

use App\Models\Badge;
use App\Models\StoreItem;
use App\Models\UserStorePurchase;
use App\Models\WeeklyChallenge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GamificationController extends ApiController
{
    // GET /api/badges  (FR-29)
    public function badges(Request $request): JsonResponse
    {
        $user       = $request->user();
        $earnedIds  = $user->badges()->pluck('badges.id');

        $badges = Badge::where('is_active', true)->get()->map(fn($badge) => [
            'id'            => $badge->id,
            'name'          => $badge->name,
            'description'   => $badge->description,
            'icon'          => $badge->icon,
            'points_reward' => $badge->points_reward,
            'earned'        => $earnedIds->contains($badge->id),
            'earned_at'     => $user->badges->find($badge->id)?->pivot->earned_at,
        ]);

        return $this->success($badges);
    }

    // GET /api/gamification/tree  (FR-30)
    public function tree(Request $request): JsonResponse
    {
        $tree = $request->user()->productivityTree;

        return $this->success([
            'health'          => $tree?->health ?? 0,
            'level'           => $tree?->level ?? 1,
            'state'           => $tree?->tree_state ?? 'wilting',
            'total_water'     => $tree?->total_water ?? 0,
            'last_watered_at' => $tree?->last_watered_at,
        ]);
    }

    // GET /api/gamification/points  (FR-28)
    public function points(Request $request): JsonResponse
    {
        $user   = $request->user();
        $points = $user->points;

        $transactions = $user->pointTransactions()
            ->orderByDesc('created_at')
            ->limit(20)
            ->get(['amount', 'reason', 'created_at']);

        return $this->success([
            'total_points'     => $points?->total_points ?? 0,
            'available_points' => $points?->available_points ?? 0,
            'recent'           => $transactions,
        ]);
    }

    // GET /api/store  (FR-31)
    public function store(Request $request): JsonResponse
    {
        $user        = $request->user();
        $purchasedIds = $user->storePurchases()->pluck('store_item_id');

        $items = StoreItem::where('is_active', true)->get()->map(fn($item) => [
            'id'           => $item->id,
            'name'         => $item->name,
            'type'         => $item->type,
            'asset_path'   => $item->asset_path,
            'price_points' => $item->price_points,
            'purchased'    => $purchasedIds->contains($item->id),
            'is_active'    => $user->storePurchases()->where('store_item_id', $item->id)->where('is_active', true)->exists(),
        ]);

        return $this->success($items);
    }

    // POST /api/store/{item}/purchase  (FR-31)
    public function purchase(Request $request, StoreItem $item): JsonResponse
    {
        $user = $request->user();

        if ($user->storePurchases()->where('store_item_id', $item->id)->exists()) {
            return $this->error('اشتريت هذا العنصر مسبقاً');
        }

        $points = $user->points;
        if (!$points || $points->available_points < $item->price_points) {
            return $this->error('نقاطك غير كافية لشراء هذا العنصر');
        }

        $points->spendPoints($item->price_points, 'store_purchase', $item);

        UserStorePurchase::create([
            'user_id'       => $user->id,
            'store_item_id' => $item->id,
            'purchased_at'  => now(),
        ]);

        return $this->success(message: "تم شراء \"{$item->name}\" بنجاح");
    }

    // POST /api/store/{item}/activate  (FR-31) — تفعيل عنصر مشترى
    public function activate(Request $request, StoreItem $item): JsonResponse
    {
        $user = $request->user();

        $purchase = $user->storePurchases()->where('store_item_id', $item->id)->first();
        if (!$purchase) return $this->error('لم تشترِ هذا العنصر بعد');

        // إلغاء تفعيل العناصر من نفس النوع
        $user->storePurchases()
            ->whereHas('storeItem', fn($q) => $q->where('type', $item->type))
            ->update(['is_active' => false]);

        $purchase->update(['is_active' => true]);

        return $this->success(message: 'تم تفعيل العنصر');
    }

    // GET /api/challenges  (FR-32)
    public function challenges(Request $request): JsonResponse
    {
        $challenges = WeeklyChallenge::where('user_id', $request->user()->id)
            ->orderByDesc('week_start')
            ->limit(10)
            ->get();

        return $this->success($challenges);
    }
}
