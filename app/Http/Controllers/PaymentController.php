<?php

namespace App\Http\Controllers;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Illuminate\Http\Request;
use Exception;
class PaymentController extends Controller
{
    public function crearPedido(Request $request)
    {
        // Configurar las credenciales de PayPal
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.client_secret');
        
        // Inicializar el contexto de la API de PayPal
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );

        // Crear el método de pago
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Configurar el monto
        $amount = new Amount();
        $amount->setTotal($request->input('cart')[0]['quantity'] * $request->input('monto_total')); // Cambia esto según tu lógica
        $amount->setCurrency('USD');

        // Crear la transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setDescription('Pago por facturas');

        // Configurar las URLs de retorno
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/')) // URL de retorno después del pago
                     ->setCancelUrl(url('/cancel'));

        // Crear el pago
        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        try {
            // Crear el pedido en PayPal
            $payment->create($apiContext);
        } catch (Exception $ex) {
            // Manejar el error
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        return response()->json(['id' => $payment->getId()]);
    }

    public function capturarPedido($orderID)
    {
        // Inicializar el contexto de la API de PayPal
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.client_secret')
            )
        );

        // Obtener el pago usando el ID del pedido
        $payment = Payment::get($orderID, $apiContext);

        // Crear el objeto de ejecución del pago
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        try {
            // Capturar el pago
            $result = $payment->execute($execution, $apiContext);
        } catch (Exception $ex) {
            // Manejar el error
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        return response()->json($result);
    }
}
