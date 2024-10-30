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

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypal.client_id'), // Client ID
                config('paypal.secret')     // Secret
            )
        );

        $this->apiContext->setConfig(config('paypal.settings'));
    }
    public function payWithPayPal(Request $request)
    {
        // Obtener 'factura_ids' asegurándose de que es un array
        $facturaIds = $request->input('factura_ids', []);
        $montoTotal = $request->input('montoTotal');
    
        // Validar que 'factura_ids' sea un array
        if (!is_array($facturaIds) || empty($facturaIds)) {
            return redirect()->route('facturas')->with('error', 'El parámetro factura_ids debe ser un array válido y no estar vacío.');
        }
        // Convertir los valores de 'factura_ids' a enteros
        $factura_ids_int = array_map('intval', $facturaIds);
         
        // Calcular el total de las facturas (si es necesario)
        $total = array_sum($factura_ids_int);
        // Verificar que 'montoTotal' es un número y es mayor que cero
        if (!is_numeric($montoTotal) || $montoTotal <= 0) {
            return redirect()->route('facturas')->with('error', 'Monto total inválido.');
        }
    
        // Preparar el pago con PayPal
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
    
        // Crear el item de pago
        $item = new Item();
        $item->setName('Pago de Facturas: ' . implode(', ', $factura_ids_int))
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice(number_format($montoTotal, 2, '.', '')); // Asegúrate de que esto sea un número válido
    
        // Crear la lista de items
        $itemList = new ItemList();
        $itemList->setItems([$item]);
    
        // Crear el monto
        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal(number_format($montoTotal, 2, '.', '')); // Asegúrate de que esto sea un número válido
    
        // Crear la transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription('Pago de facturas: ' . implode(', ', $factura_ids_int));
    
        // Configurar las URLs de redirección
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.status'))
                     ->setCancelUrl(route('paypal.status'));
    
        // Crear el pago
        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);
    
        // Intentar crear el pago
        try {
            $payment->create($this->apiContext);
            return redirect($payment->getApprovalLink());
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->route('facturas')->with('error', 'Error en el pago con PayPal: ' . $ex->getMessage());
        }
    }
    
    
    

    
    public function getPaymentStatus()
    {
        $paymentId = request('paymentId');
        $payerId = request('PayerID');

        if (empty($paymentId) || empty($payerId)) {
            return redirect()->route('home')->with('error', 'El pago fue cancelado.');
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            if ($result->getState() == 'approved') {
                return redirect()->route('home')->with('success', 'Pago realizado con éxito.');
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect()->route('home')->with('error', 'Error en el pago.');
        }

        return redirect()->route('home')->with('error', 'El pago no fue aprobado.');
    }
}
