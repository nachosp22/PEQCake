<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido recibido - PEQ Cakes</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6;">
@php
    $items = $order->normalizedItemsForAdmin();
    $subtotal = collect($items)->sum('line_total');
    $orderNumber = str_pad((string) $order->id, 4, '0', STR_PAD_LEFT);
    $logoSource = isset($message)
        ? $message->embed(public_path('img/logosinfondopeq.png'))
        : asset('img/logosinfondopeq.png');
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:620px; background-color:#ffffff; border:1px solid #e5e7eb;">
                <tr>
                    <td align="center" style="padding:28px 24px 12px 24px; border-bottom:1px solid #e5e7eb;">
                        <img src="{{ $logoSource }}" alt="PEQ Cakes" width="120" style="display:block; width:120px; max-width:120px; height:auto; margin:0 auto 16px auto;">
                        <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:26px; line-height:1.2; color:#111827; font-weight:bold;">&iexcl;Pedido #{{ $orderNumber }} recibido!</p>
                        <p style="margin:10px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.5; color:#4b5563;">
                            &iexcl;Hola {{ $order->customer_name }}!
                        </p>
                        <p style="margin:10px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.5; color:#4b5563;">
                            Ya tenemos tu pedido #{{ $orderNumber }}, pero todav&iacute;a falta el &uacute;ltimo paso.
                        </p>
                        <p style="margin:10px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.5; color:#4b5563;">
                            Para completarlo, haz un Bizum de {{ number_format($order->total, 2, ',', '.') }}&euro; al n&uacute;mero ------ e indica como concepto PEQ{{ $orderNumber }}.
                        </p>
                        <p style="margin:10px 0 0 0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.5; color:#4b5563;">
                            En cuanto recibamos el pago, te enviaremos un mail con la confirmaci&oacute;n definitiva.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 24px 0 24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:12px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#111827; background-color:#f9fafb;">
                                    <strong>Pedido #{{ $orderNumber }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#6b7280;">Email</td>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#111827; text-align:right;">{{ $order->customer_email }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#6b7280;">Telefono</td>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#111827; text-align:right;">{{ $order->customer_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#6b7280;">Fecha de recogida</td>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#111827; text-align:right;">{{ $order->pickup_date ? $order->pickup_date->format('d/m/Y') : 'Por confirmar' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#6b7280;">Lugar de recogida</td>
                                            <td style="padding:4px 0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#111827; text-align:right;">Calle La playa 6</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 24px 0 24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#6b7280; text-transform:uppercase; border-bottom:1px solid #e5e7eb;">Producto</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#6b7280; text-transform:uppercase; text-align:center; border-bottom:1px solid #e5e7eb;">Tamaño</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#6b7280; text-transform:uppercase; text-align:center; border-bottom:1px solid #e5e7eb;">Cantidad</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#6b7280; text-transform:uppercase; text-align:right; border-bottom:1px solid #e5e7eb;">Precio</td>
                            </tr>
                            @foreach ($items as $item)
                            <tr>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#111827; border-bottom:1px solid #f3f4f6;">{{ $item['cake_name'] }}</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#111827; text-align:center; border-bottom:1px solid #f3f4f6;">{{ $item['size_label'] }}</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#111827; text-align:center; border-bottom:1px solid #f3f4f6;">{{ $item['quantity'] }}</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#111827; text-align:right; border-bottom:1px solid #f3f4f6;">EUR {{ number_format($item['line_total'], 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#4b5563; text-align:right;">Subtotal</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#111827; text-align:right;">EUR {{ number_format($subtotal, 2, ',', '.') }}</td>
                            </tr>
                            @if ($order->hasDiscountSnapshot())
                            <tr>
                                <td colspan="3" style="padding:0 10px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#4b5563; text-align:right;">Descuento ({{ $order->discount_code }})</td>
                                <td style="padding:0 10px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#059669; text-align:right;">- EUR {{ number_format($order->discount_amount, 2, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" style="padding:12px 10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#111827; font-weight:bold; text-align:right; border-top:1px solid #e5e7eb;">Total</td>
                                <td style="padding:12px 10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#111827; font-weight:bold; text-align:right; border-top:1px solid #e5e7eb;">EUR {{ number_format($order->total, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @if ($order->notes)
                <tr>
                    <td style="padding:20px 24px 0 24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb; background-color:#f9fafb;">
                            <tr>
                                <td style="padding:12px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#4b5563;">
                                    <strong>Notas del pedido:</strong> {{ $order->notes }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endif

                <tr>
                    <td style="padding:22px 24px 26px 24px;">
                        <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:1.6; color:#4b5563; text-align:center;">
                            Este pedido a&uacute;n no est&aacute; confirmado. Quedar&aacute; confirmado al recibir el Bizum.
                        </p>
                        <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:1.6; color:#4b5563; text-align:center;">
                            Para cualquier consulta, puedes responder a este mismo correo o contactar con nosotros a traves de WhatsApp 666 666 666.
                        </p>
                    </td>
                </tr>
            </table>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:620px;">
                <tr>
                    <td style="padding:14px 10px 0 10px; text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#9ca3af;">
                        PEQ Cakes - Gijon
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
