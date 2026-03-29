<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Notifications\Notification;

class ProductReviewNotification extends Notification
{
    public function __construct(
        public readonly Product $product,
        public readonly string $action,
        public readonly ?string $notes = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'product_id'   => $this->product->id,
            'product_name' => $this->product->name,
            'action'       => $this->action,
            'notes'        => $this->notes,
            'link'         => route('app.products.show', $this->product->id),
        ];
    }
}
