<?php

declare(strict_types=1);

namespace Service;

use Core\Env;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private string $host;
    private int    $port;
    private string $username;
    private string $password;
    private string $from;
    private string $fromName;
    private string $encryption;
    private string $adminEmail;

    public function __construct()
    {
        $this->host       = Env::get('MAIL_HOST',      'smtp.example.com');
        $this->port       = (int) Env::get('MAIL_PORT', '587');
        $this->username   = Env::get('MAIL_USERNAME',  '');
        $this->password   = Env::get('MAIL_PASSWORD',  '');
        $this->from       = Env::get('MAIL_FROM',      'contact@jucoachsportif.com');
        $this->fromName   = Env::get('MAIL_FROM_NAME', 'Ju Coach Sportif');
        $this->encryption = Env::get('MAIL_ENCRYPTION', 'tls');
        $this->adminEmail = Env::get('MAIL_ADMIN',     'ju@jucoachsportif.com');
    }

    /* Envoi mail */

    private function send(string $to, string $subject, string $htmlBody): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $this->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;
            $mail->SMTPSecure = $this->encryption === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->port;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom($this->from, $this->fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody = strip_tags($htmlBody);

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log('[MailService::send] Erreur : ' . $mail->ErrorInfo);
            return false;
        }
    }

    /* Mail de bienvenue au client */

    public function sendBienvenue(string $to, string $prenom): bool
    {
        $subject = 'Bienvenue chez Ju Coach Sportif !';
        $body    = $this->layout("Bienvenue, {$prenom} !", "
            <p>Merci de vous être inscrit sur <strong>Ju Coach Sportif</strong>.</p>
            <p>Vous pouvez dès maintenant découvrir nos programmes de coaching personnalisés.</p>
            <a href='" . Env::get('APP_URL') . "/programmes' class='btn'>Découvrir les programmes</a>
        ");

        return $this->send($to, $subject, $body);
    }

    /* Mail de réinitialisation de mot de passe */

    public function sendReinitialisationMdp(string $to, string $token): bool
    {
        $resetUrl = Env::get('APP_URL') . '/reinitialiser-mdp?token=' . $token;
        $subject  = 'Réinitialisation de votre mot de passe';
        $body     = $this->layout("Réinitialisation du mot de passe", "
            <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
            <p>Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe :</p>
            <a href='{$resetUrl}' class='btn'>Réinitialiser mon mot de passe</a>
            <p><small>Ce lien est valable <strong>1 heure</strong>.
               Si vous n'êtes pas à l'origine de cette demande, ignorez ce mail.</small></p>
        ");

        return $this->send($to, $subject, $body);
    }

    /* Mail de confirmation d'achat au client */

    public function sendConfirmationAchat(
        string $to,
        string $prenom,
        string $programmeTitre,
        float  $montant
    ): bool {
        $subject = 'Confirmation de votre achat — Ju Coach Sportif';
        $body    = $this->layout("Achat confirmé !", "
            <p>Bonjour {$prenom},</p>
            <p>Votre achat a bien été enregistré. Merci pour votre confiance !</p>
            <table>
                <tr><td><strong>Programme</strong></td><td>{$programmeTitre}</td></tr>
                <tr><td><strong>Montant</strong></td><td>" . number_format($montant, 2) . " €</td></tr>
            </table>
            <p>Ju va prendre contact avec vous très prochainement par mail ou WhatsApp pour vous transmettre votre programme personnalisé.</p>
            <a href='" . Env::get('APP_URL') . "/mon-programme' class='btn'>Mon espace personnel</a>
        ");

        return $this->send($to, $subject, $body);
    }

    /* Notification à Ju lors d'une nouvelle commande */

    public function sendNotificationCommande(
        string $clientPrenom,
        string $clientNom,
        string $clientEmail,
        string $programmeTitre,
        float  $montant
    ): bool {
        $subject = "Nouvelle commande — {$clientPrenom} {$clientNom}";
        $body    = $this->layout("Nouvelle commande reçue !", "
            <p>Un client vient de commander un programme.</p>
            <table>
                <tr><td><strong>Client</strong></td><td>{$clientPrenom} {$clientNom}</td></tr>
                <tr><td><strong>Email</strong></td><td>{$clientEmail}</td></tr>
                <tr><td><strong>Programme</strong></td><td>{$programmeTitre}</td></tr>
                <tr><td><strong>Montant</strong></td><td>" . number_format($montant, 2) . " €</td></tr>
            </table>
            <a href='" . Env::get('APP_URL') . "/admin/clients' class='btn'>Voir les clients</a>
        ");

        return $this->send($this->adminEmail, $subject, $body);
    }

    /* Notification à Ju lors d'un nouveau message de contact */

    public function sendNotificationContact(
        string $nom,
        string $email,
        string $message
    ): bool {
        $subject = "Nouveau message de contact — {$nom}";
        $body    = $this->layout("Nouveau message reçu !", "
            <p>Un visiteur vous a envoyé un message via le formulaire de contact.</p>
            <table>
                <tr><td><strong>Nom</strong></td><td>{$nom}</td></tr>
                <tr><td><strong>Email</strong></td><td>{$email}</td></tr>
                <tr><td><strong>Message</strong></td><td>" . nl2br(htmlspecialchars($message)) . "</td></tr>
            </table>
            <a href='" . Env::get('APP_URL') . "/admin/messages' class='btn'>Voir les messages</a>
        ");

        return $this->send($this->adminEmail, $subject, $body);
    }

    /* Template HTML des mails */

    private function layout(string $title, string $content): string
    {
        return "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body        { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
                .container  { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; }
                .header     { background: #0A0A0A; padding: 30px; text-align: center; }
                .header h1  { color: #F4C52C; margin: 0; font-size: 24px; }
                .body       { padding: 30px; color: #333; line-height: 1.6; }
                .body h2    { color: #0A0A0A; }
                table       { width: 100%; border-collapse: collapse; margin: 15px 0; }
                td          { padding: 8px 12px; border-bottom: 1px solid #eee; }
                .btn        { display: inline-block; margin: 20px 0; padding: 12px 25px;
                              background: #F4C52C; color: #0A0A0A !important; text-decoration: none;
                              border-radius: 5px; font-weight: bold; }
                .footer     { background: #0A0A0A; padding: 15px; text-align: center;
                              font-size: 12px; color: #F4C52C; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>JU COACH SPORTIF</h1>
                </div>
                <div class='body'>
                    <h2>{$title}</h2>
                    {$content}
                </div>
                <div class='footer'>
                    Ju Coach Sportif — Nosy Be, Madagascar
                </div>
            </div>
        </body>
        </html>";
    }
}
