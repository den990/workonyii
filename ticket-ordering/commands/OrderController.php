<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Order;
use yii\db\Exception;

class OrderController extends Controller
{
    public function actionCreate($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity)
    {
        $user_id = 1; // сделал что у нас есть юзер
        $barcode = $this->generateUniqueBarcode();

        $bookingResponse = $this->mockApiResponse('book');

        if (isset($bookingResponse['error'])) {
            echo "Error: {$bookingResponse['error']}. Generating a new barcode...\n";
            $this->actionCreate($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity);
            return;
        }


        $approvalResponse = $this->mockApiResponse('approve');
        if (isset($approvalResponse['error'])) {
            echo "Approval Error: {$approvalResponse['error']}\n";
            return;
        }

        // Сохраняем заказ в БД
        $order = new Order();
        $order->event_id = $event_id;
        $order->user_id = $user_id;
        $order->event_date = $event_date;
        $order->ticket_adult_price = $ticket_adult_price;
        $order->ticket_adult_quantity = $ticket_adult_quantity;
        $order->ticket_kid_price = $ticket_kid_price;
        $order->ticket_kid_quantity = $ticket_kid_quantity;
        $order->barcode = $barcode;
        $order->equal_price = ($ticket_adult_price * $ticket_adult_quantity) + ($ticket_kid_price * $ticket_kid_quantity);
        $order->created = date('Y-m-d H:i:s');

        if ($order->save()) {
            echo "Order successfully created: ID {$order->id}, Barcode: $barcode\n";
        } else {
            echo "Failed to save order";
        }
    }

    private function generateUniqueBarcode()
    {
        return rand(10000000, 99999999);
    }

    private function mockApiResponse($action)
    {
        if ($action === 'book') {
            if (rand(0, 1) === 0) {
                return ['message' => 'order successfully booked'];
            } else {
                return ['error' => 'barcode already exists'];
            }
        } elseif ($action === 'approve') {
            if (rand(0, 1) === 0) {
                return ['message' => 'order successfully approved'];
            } else {
                return ['error' => 'event cancelled'];
            }
        }
        return [];
    }

}
