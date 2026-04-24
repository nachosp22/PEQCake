<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - PEQ Cakes</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 30px 15px;">
        <tr>
            <td align="center">
                
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background-color: #111111; border-radius: 20px; border: 1px solid #333333;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 30px 40px; text-align: center;">
                            <img src="{{ $message->embed(public_path('img/logosinfondopeq.png')) }}" alt="PEQ Cakes" style="height: 80px; margin-bottom: 20px;">
                            <h1 style="color: #f2b705; font-size: 28px; font-weight: bold; margin: 0;">Restablecer contraseña</h1>
                            <p style="color: #888888; font-size: 14px; margin: 10px 0 0 0;">Solicitud de cambio de contraseña</p>
                        </td>
                    </tr>
                    
                    <!-- Saludo -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <p style="color: #f7eed9; font-size: 18px; margin: 0;">¡Hola <strong>{{ $member->name }}</strong>!</p>
                            <p style="color: #888888; font-size: 14px; margin: 10px 0 0 0;">Has solicitado restablecer tu contraseña. Usa el código de abajo para crear una nueva.</p>
                        </td>
                    </tr>
                    
                    <!-- Código -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: rgba(242,183,5,0.1); border: 2px solid rgba(242,183,5,0.5); border-radius: 14px;">
                                <tr>
                                    <td style="padding: 25px; text-align: center;">
                                        <p style="color: #888888; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 10px 0;">Tu código de verificación</p>
                                        <p style="color: #f2b705; font-size: 32px; font-weight: bold; letter-spacing: 4px; margin: 0; font-family: monospace;">{{ substr($token, 0, 8) }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Botón -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/socio/reset-password?token=' . $token . '&email=' . urlencode($member->email)) }}"
                                           style="display: inline-block; background-color: #f2b705; color: #101010; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; padding: 14px 32px; border-radius: 14px;">
                                            Restablecer contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Instrucciones -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <p style="color: #888888; font-size: 13px; margin: 0 0 10px 0;">Este código expira en <strong style="color: #f7eed9;">60 minutos</strong>.</p>
                            <p style="color: #888888; font-size: 13px; margin: 0;">Si no solicitaste este cambio, puedes ignorar este email. Tu contraseña seguirá siendo la misma.</p>
                        </td>
                    </tr>
                    
                    <!-- Contacto -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <p style="color: #888888; font-size: 13px; margin: 0;">¿Alguna duda? Escríbenos a <a href="mailto:hola@peqcakes.com" style="color: #f2b705; text-decoration: none;">hola@peqcakes.com</a></p>
                        </td>
                    </tr>
                    
                </table>
                
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px;">
                    <tr>
                        <td style="padding: 30px 0; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="color: #888888; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin: 0;">PEQ Cakes • Gijón • 2026</p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>
    
</body>
</html>
